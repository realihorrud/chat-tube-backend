<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Telegram\Entities\User as TelegramUser;
use Illuminate\Support\Facades\DB;
use Throwable;

final class UsersService
{
    /**
     * @throws Throwable
     */
    public function createOrUpdate(TelegramUser $telegramUser): User
    {
        return DB::transaction(function () use ($telegramUser) {
            return User::query()->updateOrCreate(['telegram_id' => $telegramUser->id], [
                'first_name' => $telegramUser->first_name,
                'last_name' => $telegramUser->last_name,
                'username' => $telegramUser->username,
                'language_code' => $telegramUser->language_code,
            ]);
        });
    }
}
