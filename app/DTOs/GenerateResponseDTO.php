<?php

declare(strict_types=1);

namespace App\DTOs;

use Telegram\Bot\Objects\Message;

final class GenerateResponseDTO
{
    public function __construct(
        public int $chat_id,
        public int $telegram_id,
        public string $text,
    ) {}

    public static function fromMessage(Message $message): self
    {
        return new self(
            chat_id: $message->chat->id,
            telegram_id: $message->from->id,
            text: $message->text,
        );
    }
}
