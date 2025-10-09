<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

final class StartCommand extends Command
{
    protected $name = 'start';

    protected $description = 'Start Command to get you started';

    public function handle(): void
    {
        //        /** @var User $userObject */
        //        $userObject = $this->getUpdate()->getRelatedObject()->from;
        //
        //        $this->createOrUpdateUserAction->run($userObject);
        //
        //        $this->replyWithMessage([
        //            'text' => __('messages.start'),
        //        ]);
    }
}
