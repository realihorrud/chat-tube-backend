<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class CallbackQuery extends Dto
{
    public function __construct(
        public string $id,
        public User $from,
        public Optional|Message $message,
        public Optional|string $inline_message_id,
        public string $chat_instance,
        public Optional|string $data,
        public Optional|string $game_short_name,
    ) {}
}
