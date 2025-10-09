<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ChatMemberUpdated extends Dto
{
    public function __construct(
        public Chat $chat,
        public User $from,
        public int $date,
        public ChatMember $old_chat_member,
        public ChatMember $new_chat_member,
        public Optional|ChatInviteLink $invite_link,
        public Optional|bool $via_join_request,
        public Optional|bool $via_chat_folder_invite_link,
    ) {}
}
