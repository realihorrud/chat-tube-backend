<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\YoutubeVideo\YoutubeVideoDTO;
use App\Enums\ConversationStatus;
use App\Models\Conversation;
use App\Models\TelegramUser;
use App\Services\CreateTranscriptFileService;
use App\Services\YoutubeVideosService;
use App\Supadata\Entities\Error;
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
        #[Config('services.open_ai.vector_stores.expires_in_days')]
        private int $expiresInDays,
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(TelegramUser $telegramUser, YoutubeUrl $videoUrl): Conversation
    {
        $chat = DB::transaction(function () use ($telegramUser): Conversation {
            $chat = new Conversation;
            $chat->status = ConversationStatus::Processing;

            $telegramUser->chats()->save($chat);

            return $chat;
        });

        try {
            $this->processVideo($chat, $videoUrl);
        } catch (Throwable $e) {
            $chat->status = ConversationStatus::Failed;
            $chat->save();

            throw $e;
        }

        return $chat->refresh();
    }

    /**
     * @throws Throwable
     */
    private function processVideo(Conversation $chat, YoutubeUrl $videoUrl): void
    {
        $transcript = $this->sdk->universalTranscript()->getTranscript($videoUrl);
        if ($transcript instanceof Error) {
            $chat->status = ConversationStatus::Failed;
            $chat->save();

            return;
        }

        $metadata = $this->sdk->universalMetadata()->getMetadata($videoUrl->toUrl());

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
            'chat_id' => $chat->id,
            'file_id' => $file->id,
            'vector_store_id' => $vectorStoreId,
            'metadata' => $metadata,
        ]));

        DB::transaction(function () use ($chat, $metadata, $youtubeVideo): void {
            $chat->youtube_video_id = $youtubeVideo->id;
            $chat->title = $metadata->title;
            $chat->status = ConversationStatus::Ready;
            $chat->save();
        });
    }
}
