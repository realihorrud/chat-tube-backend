<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ChatState\UpdateOrCreateChatStateDTO;
use App\Models\ChatState;
use Illuminate\Support\Facades\DB;
use Throwable;

final class ChatStatesService
{
    /**
     * @throws Throwable
     */
    public function updateOrCreateState(UpdateOrCreateChatStateDTO $dto): void
    {
        DB::transaction(function () use ($dto): void {
            ChatState::query()->updateOrCreate(['chat_id' => $dto->update->message->chat->id], [
                'state' => $dto->state,
                'last_update' => $dto->update,
            ]);
        });
    }
}
