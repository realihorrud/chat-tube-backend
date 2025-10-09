<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class MessageReactionCountUpdated extends Dto
{
    public function __construct(
        public Chat $chat,
        public int $message_id,
        public int $date,
        public array $reactions,
    ) {}
}
