<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Chat extends Dto
{
    public function __construct(
        public int $id,
        public string $type,
        public Optional|string $title,
        public Optional|string $username,
        public Optional|string $first_name,
        public Optional|string $last_name,
        public Optional|bool $is_forum,
    ) {}
}
