<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\VideoProcessed;
use App\Telegram\TelegramBotApi;

final readonly class SendVideoProcessedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct(private TelegramBotApi $api) {}

    /**
     * Handle the event.
     */
    public function handle(VideoProcessed $event): void
    {
        $this->api->sendMessage([
            'chat_id' => $event->chatId,
            'text' => 'Ask anything about this video!',
            'parse_mode' => 'Markdown',
        ]);
    }
}
