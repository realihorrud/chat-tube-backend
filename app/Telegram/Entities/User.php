<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class User extends Dto
{
    public function __construct(
        public int $id,
        public bool $is_bot,
        public string $first_name,
        public ?string $last_name = '',
        public ?string $username = '',
        public ?string $language_code = 'en',
        public ?bool $is_premium = false,
        public ?bool $added_to_attachment_menu = false,
        public ?bool $has_main_web_app = false,
    ) {}
}
