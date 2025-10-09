<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ChatShared extends Dto
{
    public function __construct(
        public int $request_id,
        public int $chat_id,
        public Optional|string $title,
        public Optional|string $username,
        public Optional|array $photo,
    ) {}
}
