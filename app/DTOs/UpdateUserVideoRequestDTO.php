<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\UserVideoRequestStatus;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class UpdateUserVideoRequestDTO extends Data
{
    public function __construct(
        public Optional|int $telegramId,
        public Optional|int $chatId,
        public Optional|string $videoUrl,
        public Optional|string $prompt,
        public Optional|UserVideoRequestStatus $status,
    ) {}
}
