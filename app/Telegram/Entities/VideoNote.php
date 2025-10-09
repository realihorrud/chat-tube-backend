<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class VideoNote extends Dto
{
    public function __construct(
        public string $file_id,
        public string $file_unique_id,
        public int $length,
        public int $duration,
        public Optional|PhotoSize $thumbnail,
        public Optional|int $file_size,
    ) {}
}
