<?php

declare(strict_types=1);

namespace App\Actions\UserVideoRequest;

use App\DTOs\StoreUserVideoRequestDTO;
use App\Models\User;
use App\Models\UserVideoRequest;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

final class StoreUserVideoRequestAction
{
    /**
     * @throws Throwable
     */
    public function run(StoreUserVideoRequestDTO $dto): void
    {
        DB::transaction(function () use ($dto): void {
            $user = User::query()->firstWhere('telegram_id', $dto->telegramId);
            if (! $user instanceof User) {
                throw new RuntimeException('User not found');
            }

            $model = new UserVideoRequest();
            $model->video_url = $dto->videoUrl;
            $model->status = $dto->status->value;
            $model->chat_id = $dto->chatId;
            $model->user_id = $user->id;
            $model->message_id = $dto->messageId;

            $model->save();
        });
    }
}
