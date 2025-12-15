<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ChatState\UpdateOrCreateChatStateDTO;
use App\Models\ChatState;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Optional;
use Throwable;

final class ChatStatesService
{
    /**
     * @throws Throwable
     */
    public function updateOrCreateState(UpdateOrCreateChatStateDTO $dto): void
    {
        DB::transaction(function () use ($dto): void {
            $values = [
                'state' => $dto->state,
            ];
            if (! $dto->last_update instanceof Optional) {
                $values['last_update'] = $dto->last_update;
            }
            ChatState::query()->updateOrCreate(['chat_id' => $dto->chat_id], $values);
        });
    }
}
