<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class MessageReactionUpdated extends Dto
{
    public function __construct(
        public Chat $chat,
        public int $message_id,
        public Optional|User $user,
        public Optional|Chat $actor_chat,
        public int $date,
        public array $old_reaction,
        public array $new_reaction,
    ) {}
}
