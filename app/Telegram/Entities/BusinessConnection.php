<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class BusinessConnection extends Dto
{
    public function __construct(
        public string $id,
        public User $user,
        public int $user_chat_id,
        public int $date,
        public bool $is_enabled,
    ) {}
}
