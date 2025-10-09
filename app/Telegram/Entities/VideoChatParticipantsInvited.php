<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class VideoChatParticipantsInvited extends Dto
{
    public function __construct(
        public array $users,
    ) {}
}
