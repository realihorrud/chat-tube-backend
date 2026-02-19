<?php

declare(strict_types=1);

namespace App\DTOs\Message;

use App\Enums\MessageRole;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class MessageData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly int $chat_id,
        public readonly MessageRole $role,
        public readonly string $content,
        public readonly ?CarbonImmutable $created_at,
        public readonly ?CarbonImmutable $updated_at,
    ) {}
}
