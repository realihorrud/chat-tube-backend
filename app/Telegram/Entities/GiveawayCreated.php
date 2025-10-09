<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class GiveawayCreated extends Dto
{
    public function __construct(
        public Optional|int $prize_star_count,
    ) {}
}
