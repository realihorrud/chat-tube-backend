<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class LinkPreviewOptions extends Dto
{
    public function __construct(
        public Optional|bool $is_disabled,
        public Optional|string $url,
        public Optional|bool $prefer_small_media,
        public Optional|bool $prefer_large_media,
        public Optional|bool $show_above_text,
    ) {}
}
