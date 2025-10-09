<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class User extends Dto
{
    public function __construct(
        public int $id,
        public bool $is_bot,
        public string $first_name,
        public Optional|string $last_name,
        public Optional|string $username,
        public Optional|string $language_code,
        public Optional|bool $is_premium,
        public Optional|bool $added_to_attachment_menu,
        public Optional|bool $has_main_web_app,
    ) {}
}
