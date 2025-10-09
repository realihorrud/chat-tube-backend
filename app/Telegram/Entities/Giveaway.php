<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Giveaway extends Dto
{
    public function __construct(
        public array $chats,
        public int $winners_selection_date,
        public int $winner_count,
        public Optional|bool $only_new_members,
        public Optional|bool $has_public_winners,
        public Optional|string $prize_description,
        public Optional|array $country_codes,
        public Optional|int $prize_star_count,
        public Optional|int $premium_subscription_month_count,
    ) {}
}
