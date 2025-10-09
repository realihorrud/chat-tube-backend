<?php

declare(strict_types=1);

namespace App\Resolvers;

use Illuminate\Support\Facades\Artisan;

final class CommandsResolver
{
    public function resolve(string $command): void
    {
        Artisan::call(substr($command, 1));
    }
}
