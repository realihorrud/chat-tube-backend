<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DTOs\YoutubeVideo\YoutubeVideoDTO;
use App\Events\VideoProcessed;
use App\Models\TelegramUser;
use App\Services\CreateTranscriptFileService;
use App\Services\LoadersService;
use App\Services\YoutubeVideosService;
use App\Supadata\Entities\Error;
use App\Supadata\SupadataSDK;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Container\Attributes\Config;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Files\CreateResponse;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileResponse;
use Throwable;

final class ProcessYoutubeVideo implements ShouldQueue
{
    use Queueable;

    public int $timeout = 60;

    public function __construct(
        public readonly int $chatId,
        public readonly YoutubeUrl $videoUrl,
        public readonly string $question,
    ) {}

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     * @throws \Illuminate\Http\Client\RequestException
     * @throws Throwable
     */
    public function handle(
        TelegramBotApi $api,
        SupadataSDK $sdk,
        YoutubeVideosService $youtubeVideosService,
        CreateTranscriptFileService $createTranscriptFileService,
        LoadersService $loaderService,
        #[Config('services.open_ai.vector_stores.expires_in_days')]
        int $expiresInDays,
    ): void {
        $loaderService->startProgress('Start processing video', $this->chatId);

        $transcript = $sdk->universalTranscript()->getTranscript($this->videoUrl);
        if ($transcript instanceof Error) {
            $api->sendMessage([
                'chat_id' => $this->chatId,
                'text' => $transcript->getMessage(TelegramUser::byChatId($this->chatId)->first()->language_code),
                'parse_mode' => 'Markdown',
            ]);

            return;
        }
        $metadata = $sdk->universalMetadata()->getMetadata($this->videoUrl->toUrl());

        $loaderService->incrementLoadingBy($this->chatId, 5, 6);

        $filename = $createTranscriptFileService->handle($metadata, $transcript);
        $file = OpenAI::files()->upload([
            'file' => fopen($filename, 'r'),
            'purpose' => 'assistants',
        ]);

        $loaderService->incrementLoadingBy($this->chatId, 10, 3);

        $vectorStoreId = OpenAI::vectorStores()->create(
            parameters: [
                'name' => $metadata->id,
                'expires_after' => [
                    'anchor' => 'last_active_at',
                    'days' => $expiresInDays,
                ],
            ],
        )->id;
        $this->addFileToVectorStore($vectorStoreId, $file);

        $loaderService->incrementLoadingBy($this->chatId, 5, 7);

        $youtubeVideosService->saveYoutubeVideo(YoutubeVideoDTO::from([
            'chat_id' => $this->chatId,
            'file_id' => $file->id,
            'vector_store_id' => $vectorStoreId,
            'metadata' => $metadata,
        ]));

        event(new VideoProcessed($this->chatId, $this->question));
    }

    private function addFileToVectorStore(
        string $vectorStoreId,
        CreateResponse $file
    ): VectorStoreFileResponse {
        return OpenAI::vectorStores()->files()->create($vectorStoreId, ['file_id' => $file->id]);
    }
}
