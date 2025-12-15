<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\ChatState;
use App\Resolvers\CallbackQueryResolver;
use App\Telegram\Entities\CallbackQuery;
use App\Telegram\Entities\Update;
use Throwable;

final class CallbackHandler extends Handler
{
    public function __construct(private readonly CallbackQueryResolver $callbackQueryResolver) {}

    /**
     * @throws Throwable
     */
    public function handle(Update $update, ?ChatState $state): void
    {
        if ($update->callback_query instanceof CallbackQuery) {
            $this->callbackQueryResolver->resolve($update->callback_query);

            return;
        }

        parent::handle($update, $state);
    }
}
