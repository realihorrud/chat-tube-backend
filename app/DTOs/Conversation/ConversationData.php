<?php

declare(strict_types=1);

namespace App\DTOs\Conversation;

use App\DTOs\Message\MessageData;
use App\DTOs\YoutubeVideo\YoutubeVideoData;
use App\Enums\ConversationStatus;
use App\Models\Conversation;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;
use Spatie\LaravelData\Optional;

final class ConversationData extends Data
{
    /**
     * @param  Optional|list<MessageData>  $messages
     */
    public function __construct(
        public readonly int $id,
        public readonly int|Lazy $telegram_user_id,
        public readonly null|int|Lazy $youtube_video_id,
        public readonly ?string $title,
        public readonly ConversationStatus $status,
        public readonly null|CarbonImmutable|Lazy $created_at,
        public readonly null|CarbonImmutable|Lazy $updated_at,
        public readonly Optional|YoutubeVideoData|null|Lazy $youtubeVideo,
        #[DataCollectionOf(MessageData::class)]
        public readonly Optional|array|Lazy $messages,
    ) {}

    public static function fromModel(Conversation $chat): self
    {
        return new self(
            id: $chat->id,
            telegram_user_id: Lazy::create(fn () => $chat->telegram_user_id),
            youtube_video_id: Lazy::create(fn () => $chat->youtube_video_id),
            title: $chat->title,
            status: $chat->status,
            created_at: Lazy::create(fn () => $chat->created_at),
            updated_at: Lazy::create(fn () => $chat->updated_at),
            youtubeVideo: Lazy::create(fn () => $chat->youtubeVideo ? YoutubeVideoData::from($chat->youtubeVideo) : null),
            messages: Lazy::create(fn () => $chat->messages ? MessageData::collect($chat->messages) : null),
        );
    }
}
