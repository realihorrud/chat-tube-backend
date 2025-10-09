<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class WebAppData extends Dto
{
    public function __construct(
        public string $data,
        public string $button_text,
    ) {}
}
