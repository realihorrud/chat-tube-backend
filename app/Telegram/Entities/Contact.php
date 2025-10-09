<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Contact extends Dto
{
    public function __construct(
        public string $phone_number,
        public string $first_name,
        public Optional|string $last_name,
        public Optional|int $user_id,
        public Optional|string $vcard,
    ) {}
}
