<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

final class TelegramController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Api $telegram): string
    {
        $update = Telegram::commandsHandler(true);

        Log::channel('telegram')->debug(json_encode($update->getChat()));

        return 'ok';
    }
}
