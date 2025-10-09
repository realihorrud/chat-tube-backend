<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class BusinessMessageDeleted extends Dto
{
    public function __construct(
        public string $business_connection_id,
        public Chat $chat,
        public array $message_ids,
    ) {}
}
