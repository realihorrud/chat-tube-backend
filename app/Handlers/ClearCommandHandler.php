<?php

declare(strict_types=1);

namespace App\Handlers;

use App\DTOs\ChatState\UpdateOrCreateChatStateDTO;
use App\Enums\State;
use App\Models\ChatState;
use App\Services\ChatStatesService;
use App\Telegram\Entities\Update;
use App\Telegram\TelegramBotApi;
use Spatie\LaravelData\Optional;
use Throwable;

final class ClearCommandHandler extends Handler
{
    private const string COMMAND = '/clear';

    public function __construct(
        private readonly TelegramBotApi $api,
        private readonly ChatStatesService $chatStatesService
    ) {}

    /**
     * @throws Throwable
     */
    public function handle(Update $update, ?ChatState $state): void
    {
        if (! $update->message instanceof Optional && $update->message->text === self::COMMAND) {
            $this->chatStatesService->updateOrCreateState(UpdateOrCreateChatStateDTO::from([
                'chat_id' => $update->message->chat->id,
                'state' => State::Idle,
                'last_update' => $update,
            ]));

            $this->api->sendMessage([
                'chat_id' => $update->message->chat->id,
                'text' => __('messages.cleared'),
            ]);

            return;
        }

        parent::handle($update, $state);
    }
}
