<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class File extends Dto
{
    public function __construct(
        public string $file_id,
        public string $file_unique_id,
        public Optional|int $file_size,
        public Optional|string $file_path,
    ) {}
}
