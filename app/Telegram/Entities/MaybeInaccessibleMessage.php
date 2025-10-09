<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class MaybeInaccessibleMessage extends Dto
{
    public function __construct(
        public Chat $chat,
        public int $message_id,
        public Optional|int $date,
    ) {}
}
