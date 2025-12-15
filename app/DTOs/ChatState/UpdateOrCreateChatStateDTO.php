<?php

declare(strict_types=1);

namespace App\DTOs\ChatState;

use App\Enums\State;
use App\Telegram\Entities\Update;
use Spatie\LaravelData\Dto;

final class UpdateOrCreateChatStateDTO extends Dto
{
    public function __construct(
        public State $state,
        public Update $update,
    ) {}
}
