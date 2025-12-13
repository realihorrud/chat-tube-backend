<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserStateStatus;
use App\Models\User;
use App\Models\UserState;

final class UserStatesService
{
    public function createUserState(int $telegramId, UserStateStatus $status): int
    {
        $user = User::query()->firstWhere('telegram_id', $telegramId);

        $userState = new UserState();

        $userState->state = $status;

        $user->states()->save($userState);

        return $userState->id;
    }
}
