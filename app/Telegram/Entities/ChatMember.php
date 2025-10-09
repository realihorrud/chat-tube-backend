<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ChatMember extends Dto
{
    public function __construct(
        public string $status,
        public User $user,
        public Optional|bool $is_anonymous,
        public Optional|string $custom_title,
        public Optional|bool $can_be_edited,
        public Optional|bool $can_manage_chat,
        public Optional|bool $can_post_messages,
        public Optional|bool $can_edit_messages,
        public Optional|bool $can_delete_messages,
        public Optional|bool $can_manage_video_chats,
        public Optional|bool $can_restrict_members,
        public Optional|bool $can_promote_members,
        public Optional|bool $can_change_info,
        public Optional|bool $can_invite_users,
        public Optional|bool $can_pin_messages,
        public Optional|bool $can_manage_topics,
        public Optional|bool $is_member,
        public Optional|bool $can_send_messages,
        public Optional|bool $can_send_audios,
        public Optional|bool $can_send_documents,
        public Optional|bool $can_send_photos,
        public Optional|bool $can_send_videos,
        public Optional|bool $can_send_video_notes,
        public Optional|bool $can_send_voice_notes,
        public Optional|bool $can_send_polls,
        public Optional|bool $can_send_other_messages,
        public Optional|bool $can_add_web_page_previews,
        public Optional|int $until_date,
    ) {}
}
