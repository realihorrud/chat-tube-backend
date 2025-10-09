<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class InlineQuery extends Dto
{
    public function __construct(
        public string $id,
        public User $from,
        public string $query,
        public string $offset,
        public Optional|string $chat_type,
        public Optional|Location $location,
    ) {}
}
