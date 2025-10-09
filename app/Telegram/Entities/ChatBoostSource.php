<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ChatBoostSource extends Dto
{
    public function __construct(
        public string $source,
        public Optional|User $user,
        public Optional|int $giveaway_message_id,
        public Optional|bool $is_unclaimed,
    ) {}
}
