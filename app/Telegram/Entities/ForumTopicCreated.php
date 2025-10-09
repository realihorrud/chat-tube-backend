<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ForumTopicCreated extends Dto
{
    public function __construct(
        public string $name,
        public int $icon_color,
        public Optional|string $icon_custom_emoji_id,
    ) {}
}
