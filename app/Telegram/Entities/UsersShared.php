<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class UsersShared extends Dto
{
    public function __construct(
        public int $request_id,
        public array $users,
    ) {}
}
