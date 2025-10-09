<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class ChatInviteLink extends Dto
{
    public function __construct(
        public string $invite_link,
        public User $creator,
        public bool $creates_join_request,
        public bool $is_primary,
        public bool $is_revoked,
        public Optional|string $name,
        public Optional|int $expire_date,
        public Optional|int $member_limit,
        public Optional|int $pending_join_request_count,
    ) {}
}
