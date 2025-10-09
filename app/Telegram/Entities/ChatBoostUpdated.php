<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class ChatBoostUpdated extends Dto
{
    public function __construct(
        public Chat $chat,
        public ChatBoost $boost,
    ) {}
}
