<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class GiveawayWinners extends Dto
{
    public function __construct(
        public Chat $chat,
        public int $giveaway_message_id,
        public int $winners_selection_date,
        public int $winner_count,
        public array $winners,
        public Optional|int $additional_chat_count,
        public Optional|int $prize_star_count,
        public Optional|int $premium_subscription_month_count,
        public Optional|int $unclaimed_prize_count,
        public Optional|bool $only_new_members,
        public Optional|bool $was_refunded,
        public Optional|string $prize_description,
    ) {}
}
