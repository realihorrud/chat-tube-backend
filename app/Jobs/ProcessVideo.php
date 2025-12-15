<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Events\VideoProcessed;
use App\Models\YoutubeVideo;
use App\Services\CreateTranscriptFileService;
use App\Services\YoutubeVideosService;
use App\Supadata\Entities\Metadata;
use App\Supadata\Entities\Transcript;
use App\Supadata\SupadataSDK;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use OpenAI\Client;
use OpenAI\Responses\Files\CreateResponse;
use OpenAI\Responses\VectorStores\Files\VectorStoreFileResponse;
use Throwable;

final class ProcessVideo implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public readonly int $chatId,
        public readonly YoutubeUrl $videoUrl,
    ) {
    }

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
        Client $client
    ): void {
        $this->sendWaitingMessage($api);

        $transcript = $sdk->universalTranscript()->getTranscript($this->videoUrl);
        $metadata = $sdk->universalMetadata()->getMetadata($this->videoUrl->toUrl());

        $file = $this->uploadFile($metadata, $transcript, $client, $createTranscriptFileService);
        $vectorStoreId = $this->findOrCreateVectorStore($client);
        $this->addFileToVectorStore($client, $vectorStoreId, $file);

        $youtubeVideosService->saveYoutubeVideo($vectorStoreId, $file->id, $metadata);

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

    private function uploadFile(
        Metadata $metadata,
        Transcript $transcript,
        Client $client,
        CreateTranscriptFileService $createTranscriptFileService
    ): CreateResponse {
        $transcriptFileContent = $createTranscriptFileService->handle($metadata, $transcript);

        return $client->files()->upload(['file' => $transcriptFileContent, 'purpose' => 'assistants']);
    }

    private function findOrCreateVectorStore(Client $client): string
    {
        $firstYoutubeVideo = YoutubeVideo::query()->first();
        if (blank($firstYoutubeVideo)) {
            return $client->vectorStores()->create(['name' => 'Youtube Videos'])->id;
        }

        return $firstYoutubeVideo->vector_store_id;
    }

    private function addFileToVectorStore(
        Client $client,
        string $vectorStoreId,
        CreateResponse $file
    ): VectorStoreFileResponse {
        return $client->vectorStores()->files()->create($vectorStoreId, ['file_id' => $file->id]);
    }
}
