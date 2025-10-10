<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\User\CreateOrUpdateUserAction;
use App\Telegram\Entities\Update;
use App\Telegram\Entities\User;
use App\Telegram\TelegramBotApi;
use Illuminate\Console\Command;
use Throwable;
use Webmozart\Assert\Assert;

final class StartCommand extends Command
{
    protected $signature = 'start {update}';

    protected $description = 'User started the bot';

    /**
     * @throws Throwable
     */
    public function handle(TelegramBotApi $api, CreateOrUpdateUserAction $action): void
    {
        $update = $this->argument('update');
        Assert::isInstanceOf($update, Update::class);
        Assert::isInstanceOf($update->message->from, User::class);

        $action->run($update->message->from);

        $api->sendMessage(['chat_id' => $update->message->chat->id, 'text' => __('messages.start')]);
    }
}
