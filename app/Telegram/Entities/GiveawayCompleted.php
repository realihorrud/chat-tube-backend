<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class GiveawayCompleted extends Dto
{
    public function __construct(
        public int $winner_count,
        public Optional|int $unclaimed_prize_count,
        public Optional|Message $giveaway_message,
        public Optional|bool $is_star_giveaway,
    ) {}
}
