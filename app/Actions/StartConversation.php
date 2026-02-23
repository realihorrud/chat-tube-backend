<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\YoutubeVideo\YoutubeVideoDTO;
use App\Enums\ConversationStatus;
use App\Models\Conversation;
use App\Models\TelegramUser;
use App\Models\YoutubeVideo;
use App\Services\CreateTranscriptFileService;
use App\Services\YoutubeVideosService;
use App\Supadata\Entities\Error;
use App\Supadata\Entities\Metadata;
use App\Supadata\SupadataSDK;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Container\Attributes\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Throwable;

final readonly class StartConversation
{
    public function __construct(
        private SupadataSDK $sdk,
        private YoutubeVideosService $youtubeVideosService,
        private CreateTranscriptFileService $createTranscriptFileService,
        private CreateConversationMessage $createConversationMessage,
        #[Config('services.openai.vector_stores.expires_in_days')]
        private int $expiresInDays,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(TelegramUser $telegramUser, YoutubeUrl $videoUrl): Conversation
    {
        $conversation = DB::transaction(function () use ($telegramUser): Conversation {
            $conversation = new Conversation;
            $conversation->status = ConversationStatus::Processing;

            $telegramUser->conversations()->save($conversation);

            return $conversation;
        });

        try {
            $this->processVideo($conversation, $videoUrl);
        } catch (Throwable $e) {
            $conversation->status = ConversationStatus::Failed;
            $conversation->save();

            throw $e;
        }

        return $conversation->refresh();
    }

    /**
     * @throws Throwable
     */
    private function processVideo(Conversation $conversation, YoutubeUrl $videoUrl): void
    {
        $metadata = $this->sdk->universalMetadata()->getMetadata($videoUrl->toUrl());

        $youtubeVideo = YoutubeVideo::query()->firstWhere('video_id', $metadata->id);
        if (! empty($youtubeVideo)) {
            $this->makeConversationReady($conversation, $metadata, $youtubeVideo);

            return;
        }

        $transcript = $this->sdk->universalTranscript()->getTranscript($videoUrl, text: true);
        if ($transcript instanceof Error) {
            $conversation->status = ConversationStatus::Failed;
            $conversation->save();

            return;
        } else if (is_string($transcript)) {
            // If the transcript is a string, it means that the video is not yet transcribed.
        }

        $filename = $this->createTranscriptFileService->handle($metadata, $transcript);

        $file = OpenAI::files()->upload([
            'file' => fopen($filename, 'r'),
            'purpose' => 'assistants',
        ]);

        Log::channel('openai')->info('Transcription file was uploaded to OpenAI');

        $vectorStoreId = OpenAI::vectorStores()->create(
            parameters: [
                'name' => $metadata->id,
                'expires_after' => [
                    'anchor' => 'last_active_at',
                    'days' => $this->expiresInDays,
                ],
            ],
        )->id;

        Log::channel('openai')->info('Vector store was successfully created');

        OpenAI::vectorStores()->files()->create($vectorStoreId, ['file_id' => $file->id]);

        Log::channel('openai')->info('Transcription file was successfully attached to vector store');

        $youtubeVideo = $this->youtubeVideosService->saveYoutubeVideo(YoutubeVideoDTO::from([
            'conversation_id' => $conversation->id,
            'file_id' => $file->id,
            'vector_store_id' => $vectorStoreId,
            'metadata' => $metadata,
        ]));

        $this->makeConversationReady($conversation, $metadata, $youtubeVideo);
    }

    private function makeConversationReady(Conversation $conversation, Metadata $metadata, YoutubeVideo $youtubeVideo): void
    {
        $readyMessage = 'Your video has been processed successfully! Ask me anything about it.';

        DB::transaction(function () use ($conversation, $metadata, $youtubeVideo): void {
            $conversation->youtube_video_id = $youtubeVideo->id;
            $conversation->title = $metadata->title;
            $conversation->status = ConversationStatus::Ready;
            $conversation->save();
        });

        $this->createConversationMessage->handle($conversation, $readyMessage);
    }
}
