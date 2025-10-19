<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Dto;

final class InlineKeyboardMarkup extends Dto implements Arrayable
{
    public function __construct(
        /** @var array[][] */
        public array $inline_keyboard,
    ) {}

    public function toArray(): array
    {
        return [
            'inline_keyboard' => array_map(
                callback: static fn (array $row) => array_map(
                    callback: static fn (InlineKeyboardButton $button) => $button->toArray(),
                    array: $row,
                ),
                array: $this->inline_keyboard
            ),
        ];
    }
}
