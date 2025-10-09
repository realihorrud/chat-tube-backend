<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class ChatBoostRemoved extends Dto
{
    public function __construct(
        public Chat $chat,
        public string $boost_id,
        public int $remove_date,
        public ChatBoostSource $source,
    ) {}
}
