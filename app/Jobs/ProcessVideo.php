<?php

declare(strict_types=1);

namespace App\Jobs;

use App\DTOs\YoutubeVideo\YoutubeVideoDTO;
use App\Events\VideoProcessed;
use App\Services\CreateTranscriptFileService;
use App\Services\YoutubeVideosService;
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

final class ProcessVideo implements ShouldQueue
{
    use Queueable;

    public int $timeout = 60;

    public function __construct(
        public readonly int $chatId,
        public readonly YoutubeUrl $videoUrl,
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
        #[Config('services.open_ai.vector_stores.expires_in_days')]
        int $expiresInDays,
    ): void {
        $this->sendWaitingMessage($api);

        $transcript = $sdk->universalTranscript()->getTranscript($this->videoUrl);
        $metadata = $sdk->universalMetadata()->getMetadata($this->videoUrl->toUrl());

        $filename = $createTranscriptFileService->handle($metadata, $transcript);
        $file = OpenAI::files()->upload([
            'file' => fopen($filename, 'r'),
            'purpose' => 'assistants',
        ]);

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

        $youtubeVideosService->saveYoutubeVideo(YoutubeVideoDTO::from([
            'chat_id' => $this->chatId,
            'file_id' => $file->id,
            'vector_store_id' => $vectorStoreId,
            'metadata' => $metadata,
        ]));

        event(new VideoProcessed($this->chatId));
    }

    private function sendWaitingMessage(TelegramBotApi $api): void
    {
        $api->sendMessage([
            'chat_id' => $this->chatId,
            'text' => 'Processing video...',
            'parse_mode' => 'Markdown',
        ]);
    }

    private function addFileToVectorStore(
        string $vectorStoreId,
        CreateResponse $file
    ): VectorStoreFileResponse {
        return OpenAI::vectorStores()->files()->create($vectorStoreId, ['file_id' => $file->id]);
    }
}
