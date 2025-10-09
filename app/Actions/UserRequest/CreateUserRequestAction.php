<?php

declare(strict_types=1);

namespace App\Actions\UserRequest;

use App\DTOs\CreateUserRequestDTO;
use App\Models\User;
use App\Models\UserRequest;
use Illuminate\Support\Facades\DB;
use Throwable;

final class CreateUserRequestAction
{
    /**
     * @throws Throwable
     */
    public function run(CreateUserRequestDTO $dto): void
    {
        DB::transaction(function () use ($dto): void {
            $user = User::query()->firstWhere('telegram_id', $dto->telegramId);
            assert($user instanceof User);

            $user->requests()->save(new UserRequest());
        });
    }
}
