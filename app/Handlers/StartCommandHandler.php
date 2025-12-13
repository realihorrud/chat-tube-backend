<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Actions\User\CreateOrUpdateUserAction;
use App\Telegram\Entities\Update;
use App\Telegram\Entities\User;
use App\Telegram\TelegramBotApi;
use Throwable;
use Webmozart\Assert\Assert;

final class StartCommandHandler extends Handler
{
    private const string COMMAND = '/start';

    public function __construct(private readonly TelegramBotApi $api, private readonly CreateOrUpdateUserAction $action) {}

    /**
     * @throws Throwable
     */
    public function handle(Update $update): void
    {
        if ($update->message->text === self::COMMAND) {
            Assert::isInstanceOf($update->message->from, User::class);

            $this->action->run($update->message->from);

            $this->api->sendMessage(['chat_id' => $update->message->chat->id, 'text' => __('messages.start')]);
        }

        parent::handle($update);
    }
}
