<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class WriteAccessAllowed extends Dto
{
    public function __construct(
        public Optional|bool $from_request,
        public Optional|string $web_app_name,
        public Optional|bool $from_attachment_menu,
    ) {}
}
