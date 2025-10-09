<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Game extends Dto
{
    public function __construct(
        public string $title,
        public string $description,
        public array $photo,
        public Optional|string $text,
        public Optional|array $text_entities,
        public Optional|Animation $animation,
    ) {}
}
