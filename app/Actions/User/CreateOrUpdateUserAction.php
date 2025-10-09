<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Objects\User as TelegramUser;
use Throwable;

final class CreateOrUpdateUserAction
{
    /**
     * @throws Throwable
     */
    public function run(TelegramUser $userObject): User
    {
        return DB::transaction(function () use ($userObject) {
            return User::query()->updateOrCreate(['telegram_id' => $userObject->id], [
                'first_name' => $userObject->firstName,
                'last_name' => $userObject->lastName,
                'username' => $userObject->username,
                'language_code' => $userObject->languageCode,
            ]);
        });
    }
}
