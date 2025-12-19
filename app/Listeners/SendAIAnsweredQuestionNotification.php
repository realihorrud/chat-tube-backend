<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DTOs\ChatState\UpdateChatStateDTO;
use App\Events\AIAnsweredQuestion;
use App\Models\ChatState;
use App\Services\ChatStatesService;
use App\Telegram\TelegramBotApi;
use Throwable;

final readonly class SendAIAnsweredQuestionNotification
{
    public function __construct(private TelegramBotApi $api, private ChatStatesService $chatStatesService) {}

    /**
     * @throws Throwable
     */
    public function handle(AIAnsweredQuestion $event): void
    {
        $message = $this->api->sendMessage([
            'chat_id' => $event->chatId,
            'text' => 'Keep asking questions or upload another video',
        ]);

        $this->chatStatesService->update(
            chatState: ChatState::byChatId($event->chatId)->first(),
            dto: UpdateChatStateDTO::from(['last_message_id' => $message->message_id, 'last_message' => $message->text])
        );
    }
}
