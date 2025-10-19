<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\UserVideoRequestStatus;
use App\Telegram\Entities\Update;
use Spatie\LaravelData\Dto;

final class StoreUserVideoRequestDTO extends Dto
{
    public function __construct(
        public int $telegramId,
        public int $chatId,
        public string $videoUrl,
        public int $messageId,
        public UserVideoRequestStatus $status,
    ) {}

    public static function fromUpdate(Update $update): self
    {
        return new self(
            telegramId: $update->message->from->id,
            chatId: $update->message->chat->id,
            videoUrl: (string) $update->message->text,
            messageId: $update->message->message_id,
            status: UserVideoRequestStatus::Pending,
        );
    }
}
