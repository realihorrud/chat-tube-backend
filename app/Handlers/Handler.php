<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\ChatState;
use App\Telegram\Entities\Update;
use LogicException;

abstract class Handler
{
    private ?Handler $nextHandler = null;

    public function setNextHandler(self $handler): self
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(Update $update, ?ChatState $state): void
    {
        if (! $this->nextHandler) {
            throw new LogicException('No next handler set.');
        }

        $this->nextHandler->handle($update, $state);
    }
}
