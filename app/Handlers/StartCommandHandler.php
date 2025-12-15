<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\ChatState\UpdateOrCreateChatStateDTO;
use App\Enums\State;
use App\Models\ChatState;
use App\Services\ChatStatesService;
use App\Services\UsersService;
use App\Telegram\Entities\Update;
use App\Telegram\Entities\User;
use App\Telegram\TelegramBotApi;
use Spatie\LaravelData\Optional;
use Throwable;
use Webmozart\Assert\Assert;

final class StartCommandHandler extends Handler
{
    private const string COMMAND = '/start';

    public function __construct(
        private readonly TelegramBotApi $api,
        private readonly UsersService $usersService,
        private readonly ChatStatesService $chatStatesService
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(Update $update, ?ChatState $state): void
    {
        if (! $update->message instanceof Optional && $update->message->text === self::COMMAND) {
            Assert::isInstanceOf($update->message->from, User::class);

            $user = $this->usersService->createOrUpdate($update->message->from);

            $this->chatStatesService->updateOrCreateState(UpdateOrCreateChatStateDTO::from([
                'state' => State::Idle,
                'update' => $update,
            ]));

            $this->api->sendMessage(['chat_id' => $update->message->chat->id, 'text' => __('messages.start')]);

            return;
        }

        parent::handle($update, $state);
    }
}
