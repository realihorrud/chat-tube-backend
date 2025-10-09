<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ChatJoinRequest extends Dto
{
    public function __construct(
        public Chat $chat,
        public User $from,
        public int $user_chat_id,
        public int $date,
        public Optional|string $bio,
        public Optional|ChatInviteLink $invite_link,
    ) {}
}
