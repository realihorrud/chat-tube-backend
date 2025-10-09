<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class TextQuote extends Dto
{
    public function __construct(
        public string $text,
        public Optional|array $entities,
        public int $position,
        public Optional|bool $is_manual,
    ) {}
}
