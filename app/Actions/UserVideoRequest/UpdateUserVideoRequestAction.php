<?php

declare(strict_types=1);

namespace App\Actions\UserVideoRequest;

use App\DTOs\UpdateUserVideoRequestDTO;
use App\Models\UserVideoRequest;
use Illuminate\Support\Facades\DB;
use Throwable;

final class UpdateUserVideoRequestAction
{
    /**
     * @throws Throwable
     */
    public function run(UserVideoRequest $userVideoRequest, UpdateUserVideoRequestDTO $dto): void
    {
        DB::transaction(function () use ($userVideoRequest, $dto): void {
            $userVideoRequest->update($dto->toArray());
        });
    }
}
