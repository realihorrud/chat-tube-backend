<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ExternalReplyInfo extends Dto
{
    public function __construct(
        public MessageOrigin $origin,
        public Optional|Chat $chat,
        public Optional|int $message_id,
        public Optional|LinkPreviewOptions $link_preview_options,
        public Optional|Animation $animation,
        public Optional|Audio $audio,
        public Optional|Document $document,
        public Optional|array $paid_media,
        public Optional|array $photo,
        public Optional|Sticker $sticker,
        public Optional|Story $story,
        public Optional|Video $video,
        public Optional|VideoNote $video_note,
        public Optional|Voice $voice,
        public Optional|bool $has_media_spoiler,
        public Optional|Contact $contact,
        public Optional|Dice $dice,
        public Optional|Game $game,
        public Optional|Giveaway $giveaway,
        public Optional|GiveawayWinners $giveaway_winners,
        public Optional|Invoice $invoice,
        public Optional|Location $location,
        public Optional|Poll $poll,
        public Optional|Venue $venue,
    ) {}
}
