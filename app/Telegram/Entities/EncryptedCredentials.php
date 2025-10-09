<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class EncryptedCredentials extends Dto
{
    public function __construct(
        public string $data,
        public string $hash,
        public string $secret,
    ) {}
}
