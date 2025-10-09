<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class ChatBoost extends Dto
{
    public function __construct(
        public string $boost_id,
        public int $add_date,
        public int $expiration_date,
        public ChatBoostSource $source,
    ) {}
}
