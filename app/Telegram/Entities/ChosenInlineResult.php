<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ChosenInlineResult extends Dto
{
    public function __construct(
        public string $result_id,
        public User $from,
        public Optional|Location $location,
        public Optional|string $inline_message_id,
        public string $query,
    ) {}
}
