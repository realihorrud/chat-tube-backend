<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Actions\UserRequest\CreateUserRequestAction;
use App\DTOs\CreateUserRequestDTO;
use App\Events\VideoSummarized;
use Throwable;

final readonly class LogUserActivity
{
    public function __construct(private CreateUserRequestAction $createUserRequestAction) {}

    /**
     * @throws Throwable
     */
    public function handle(VideoSummarized $event): void
    {
        $this->createUserRequestAction->run(CreateUserRequestDTO::fromTelegramId($event->telegramId));
    }
}
