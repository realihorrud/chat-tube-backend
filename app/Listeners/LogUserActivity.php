<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\VideoSummarized;
use Throwable;

final readonly class LogUserActivity
{
    /**
     * @throws Throwable
     */
    public function handle(VideoSummarized $event): void
    {
        //        $this->createUserRequestAction->run(CreateUserRequestDTO::fromTelegramId($event->telegramId));
    }
}
