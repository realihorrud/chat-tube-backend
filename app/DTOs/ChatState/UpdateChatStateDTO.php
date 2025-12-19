<?php

declare(strict_types=1);

namespace App\DTOs\ChatState;

use App\Enums\State;
use App\Telegram\Entities\Update;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

final class UpdateChatStateDTO extends Data
{
    public function __construct(
        public Optional|int $chat_id,
        public Optional|State $state,
        public Optional|Update $last_update,
        public Optional|int $last_message_id,
        public Optional|string $last_message,
    ) {}
}
