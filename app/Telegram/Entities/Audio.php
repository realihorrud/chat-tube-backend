<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Audio extends Dto
{
    public function __construct(
        public string $file_id,
        public string $file_unique_id,
        public int $duration,
        public Optional|string $performer,
        public Optional|string $title,
        public Optional|string $file_name,
        public Optional|string $mime_type,
        public Optional|int $file_size,
        public Optional|PhotoSize $thumbnail,
    ) {}
}
