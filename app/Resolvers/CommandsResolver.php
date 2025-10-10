<?php

declare(strict_types=1);

namespace App\Resolvers;

use App\Telegram\Entities\Update;
use Illuminate\Support\Facades\Artisan;

final class CommandsResolver
{
    public function resolve(Update $update): void
    {
        Artisan::call(mb_substr($update->message->text, 1), ['update' => $update]);
    }
}
