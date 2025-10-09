<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ForumTopicEdited extends Dto
{
    public function __construct(
        public Optional|string $name,
        public Optional|string $icon_custom_emoji_id,
    ) {}
}
