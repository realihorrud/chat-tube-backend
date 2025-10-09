<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Sticker extends Dto
{
    public function __construct(
        public string $file_id,
        public string $file_unique_id,
        public string $type,
        public int $width,
        public int $height,
        public bool $is_animated,
        public bool $is_video,
        public Optional|PhotoSize $thumbnail,
        public Optional|string $emoji,
        public Optional|string $set_name,
        public Optional|File $premium_animation,
        public Optional|MaskPosition $mask_position,
        public Optional|string $custom_emoji_id,
        public Optional|bool $needs_repainting,
        public Optional|int $file_size,
    ) {}
}
