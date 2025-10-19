<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class InlineKeyboardButton extends Dto implements Arrayable
{
    public function __construct(
        public string $text,
        public Optional|string $url = '',
        public Optional|string $callback_data = '',
        public Optional|string $switch_inline_query = '',
        public Optional|string $switch_inline_query_current_chat = '',
        public Optional|bool $pay = false,
    ) {}

    public function toArray(): array
    {
        $data = ['text' => $this->text];

        if (! ($this->url instanceof Optional) && $this->url !== '') {
            $data['url'] = $this->url;
        }
        if (! ($this->callback_data instanceof Optional) && $this->callback_data !== '') {
            $data['callback_data'] = $this->callback_data;
        }
        if (! ($this->switch_inline_query instanceof Optional) && $this->switch_inline_query !== '') {
            $data['switch_inline_query'] = $this->switch_inline_query;
        }
        if (! ($this->switch_inline_query_current_chat instanceof Optional) && $this->switch_inline_query_current_chat !== '') {
            $data['switch_inline_query_current_chat'] = $this->switch_inline_query_current_chat;
        }
        if (! ($this->pay instanceof Optional) && $this->pay === true) {
            $data['pay'] = true;
        }

        return $data;
    }
}
