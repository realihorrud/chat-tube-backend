<?php

declare(strict_types=1);

namespace App\DTOs;

use Telegram\Bot\Objects\CallbackQuery;

final readonly class ChooseModeDTO
{
    public function __construct(public int $telegram_id, public string $data) {}

    public static function fromCallbackQuery(CallbackQuery $callbackQuery): self
    {
        return new self($callbackQuery->from->id, $callbackQuery->data);
    }
}
