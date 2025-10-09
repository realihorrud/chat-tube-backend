<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class MessageOrigin extends Dto
{
    public function __construct(
        public string $type,
        public int $date,
        public Optional|User $sender_user,
        public Optional|string $sender_user_name,
        public Optional|Chat $sender_chat,
        public Optional|string $author_signature,
    ) {}
}
