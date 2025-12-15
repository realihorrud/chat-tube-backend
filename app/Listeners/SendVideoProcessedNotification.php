<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DTOs\ChatState\UpdateOrCreateChatStateDTO;
use App\Enums\State;
use App\Events\VideoProcessed;
use App\Services\ChatStatesService;
use App\Telegram\TelegramBotApi;
use Throwable;

final readonly class SendVideoProcessedNotification
{
    public function __construct(private TelegramBotApi $api, private ChatStatesService $chatStatesService) {}

    /**
     * @throws Throwable
     */
    public function handle(VideoProcessed $event): void
    {
        $this->chatStatesService->updateOrCreateState(UpdateOrCreateChatStateDTO::from([
            'chat_id' => $event->chatId,
            'state' => State::QuestionAsking,
        ]));

        $this->api->sendMessage([
            'chat_id' => $event->chatId,
            'text' => 'Ask anything about this video!',
            'parse_mode' => 'Markdown',
        ]);
    }
}
