<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Telegram\Entities\Update;
use LogicException;

abstract class Handler
{
    private ?Handler $nextHandler = null;

    public function setNextHandler(self $handler): self
    {
        $this->nextHandler = $handler;

        return $this;
    }

    public function handle(Update $update): void
    {
        if (! $this->nextHandler) {
            throw new LogicException('No next handler set.');
        }

        $this->nextHandler->handle($update);
    }
}
