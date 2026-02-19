<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTOs\YoutubeVideo\YoutubeVideoDTO;
use App\Enums\ChatStatus;
use App\Models\Chat;
use App\Models\TelegramUser;
use App\Models\YoutubeVideo;
use App\Services\CreateTranscriptFileService;
use App\Services\YoutubeVideosService;
use App\Supadata\Entities\Error;
use App\Supadata\SupadataSDK;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Container\Attributes\Config;
use Illuminate\Support\Facades\DB;
use OpenAI\Laravel\Facades\OpenAI;
use Throwable;

final readonly class CreateChatAction
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
    public function handle(TelegramUser $telegramUser, YoutubeUrl $videoUrl): Chat
    {
        $chat = DB::transaction(function () use ($telegramUser): Chat {
            $chat = new Chat;
            $chat->telegram_user_id = $telegramUser->id;
            $chat->status = ChatStatus::Processing;
            $chat->save();

            return $chat;
        });

        try {
            $this->processVideo($chat, $videoUrl);
        } catch (Throwable $e) {
            $chat->status = ChatStatus::Failed;
            $chat->save();

            throw $e;
        }

        return $chat->refresh();
    }

    /**
     * @throws Throwable
     */
    private function processVideo(Chat $chat, YoutubeUrl $videoUrl): void
    {
        $transcript = $this->sdk->universalTranscript()->getTranscript($videoUrl);
        if ($transcript instanceof Error) {
            $chat->status = ChatStatus::Failed;
            $chat->save();

            return;
        }

        $metadata = $this->sdk->universalMetadata()->getMetadata($videoUrl->toUrl());

        $filename = $this->createTranscriptFileService->handle($metadata, $transcript);
        $file = OpenAI::files()->upload([
            'file' => fopen($filename, 'r'),
            'purpose' => 'assistants',
        ]);

        $vectorStoreId = OpenAI::vectorStores()->create(
            parameters: [
                'name' => $metadata->id,
                'expires_after' => [
                    'anchor' => 'last_active_at',
                    'days' => $this->expiresInDays,
                ],
            ],
        )->id;

        OpenAI::vectorStores()->files()->create($vectorStoreId, ['file_id' => $file->id]);

        $this->youtubeVideosService->saveYoutubeVideo(YoutubeVideoDTO::from([
            'chat_id' => $chat->id,
            'file_id' => $file->id,
            'vector_store_id' => $vectorStoreId,
            'metadata' => $metadata,
        ]));

        DB::transaction(function () use ($chat, $metadata): void {
            $youtubeVideo = YoutubeVideo::query()
                ->where('chat_id', $chat->telegramUser->telegram_id)
                ->latest()
                ->first();

            $chat->youtube_video_id = $youtubeVideo?->id;
            $chat->title = $metadata->title;
            $chat->status = ChatStatus::Ready;
            $chat->save();
        });
    }
}
