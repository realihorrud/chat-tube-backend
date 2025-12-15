<?php

declare(strict_types=1);

namespace App\DTOs\ChatState;

use App\Enums\State;
use App\Telegram\Entities\Update;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class UpdateOrCreateChatStateDTO extends Dto
{
    public function __construct(
        public int $chat_id,
        public State $state,
        public Optional|Update $last_update,
    ) {}
}
