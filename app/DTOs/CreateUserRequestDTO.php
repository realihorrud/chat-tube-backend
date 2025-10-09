<?php

declare(strict_types=1);

namespace App\DTOs;

final readonly class CreateUserRequestDTO
{
    public function __construct(public int $telegramId) {}

    public static function fromTelegramId(int $telegramId): self
    {
        return new self($telegramId);
    }
}
