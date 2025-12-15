<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\ChatState;
use App\Telegram\Entities\CallbackQuery;
use App\Telegram\Entities\Update;

final class CallbackHandler extends Handler
{
    public function handle(Update $update, ?ChatState $state): void
    {
        if ($update->callback_query instanceof CallbackQuery) {
            return;
        }

        parent::handle($update, $state);
    }
}
