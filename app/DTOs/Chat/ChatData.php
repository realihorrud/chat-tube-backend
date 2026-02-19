<?php

declare(strict_types=1);

namespace App\DTOs\Chat;

use App\DTOs\Message\MessageData;
use App\DTOs\YoutubeVideo\YoutubeVideoData;
use App\Enums\ChatStatus;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class ChatData extends Data
{
    /**
     * @param  Optional|list<MessageData>  $messages
     */
    public function __construct(
        public readonly int $id,
        public readonly int $telegram_user_id,
        public readonly ?int $youtube_video_id,
        public readonly ?string $title,
        public readonly ChatStatus $status,
        public readonly ?CarbonImmutable $created_at,
        public readonly ?CarbonImmutable $updated_at,
        public readonly Optional|YoutubeVideoData|null $youtubeVideo,
        #[DataCollectionOf(MessageData::class)]
        public readonly Optional|array $messages,
    ) {}
}
