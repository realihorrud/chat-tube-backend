<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\AIAnsweredQuestion;
use App\Telegram\TelegramBotApi;

final readonly class SendAIAnsweredQuestionNotification
{
    public function __construct(private TelegramBotApi $api) {}

    /**
     * Handle the event.
     */
    public function handle(AIAnsweredQuestion $event): void
    {
        $this->api->sendMessage([
            'chat_id' => $event->chatId,
            'text' => 'Keep asking questions or if you want to upload another video enter /clear, then send the link of youtube video again.',
        ]);
    }
}
