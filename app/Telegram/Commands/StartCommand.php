<?php

declare(strict_types=1);

namespace App\Telegram\Commands;

use App\Actions\User\CreateOrUpdateUserAction;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Objects\User;

final class StartCommand extends Command
{
    protected string $name = 'start';

    protected string $description = 'Start Command to get you started';

    public function __construct(private readonly CreateOrUpdateUserAction $createOrUpdateUserAction) {}

    public function handle(): void
    {
        /** @var User $userObject */
        $userObject = $this->getUpdate()->getRelatedObject()->from;

        $this->createOrUpdateUserAction->run($userObject);

        $this->replyWithMessage([
            'text' => 'TODO',
        ]);
    }
}
