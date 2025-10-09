<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class PollAnswer extends Dto
{
    public function __construct(
        public string $poll_id,
        public Optional|Chat $voter_chat,
        public Optional|User $user,
        public array $option_ids,
    ) {}
}
