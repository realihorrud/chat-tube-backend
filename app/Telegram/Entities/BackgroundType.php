<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class BackgroundType extends Dto
{
    public function __construct(
        public string $type,
        public Optional|Document $document,
        public Optional|int $dark_theme_dimming,
        public Optional|bool $is_blurred,
        public Optional|bool $is_moving,
    ) {}
}
