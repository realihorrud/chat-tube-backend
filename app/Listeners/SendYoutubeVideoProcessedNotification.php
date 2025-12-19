<?php

declare(strict_types=1);

namespace App\Listeners;

use App\DTOs\ChatState\UpdateChatStateDTO;
use App\Enums\State;
use App\Events\VideoProcessed;
use App\Jobs\AskQuestionAboutYoutubeVideo;
use App\Models\ChatState;
use App\Services\ChatStatesService;
use App\Telegram\TelegramBotApi;
use Throwable;

final readonly class SendYoutubeVideoProcessedNotification
{
    public function __construct(private TelegramBotApi $api, private ChatStatesService $chatStatesService) {}

    /**
     * @throws Throwable
     */
    public function handle(VideoProcessed $event): void
    {
        $chatState = ChatState::byChatId($event->chatId)->first();
        $this->chatStatesService->update($chatState, UpdateChatStateDTO::from([
            'state' => State::QuestionAsking,
        ]));

        if ($event->question !== '') {
            dispatch(new AskQuestionAboutYoutubeVideo($event->chatId, $event->question, askedImmediately: true));
        } else {
            $this->api->editMessageText([
                'message_id' => (int) $chatState->last_message_id,
                'chat_id' => $event->chatId,
                'text' => 'Ask anything about this video',
                'parse_mode' => 'Markdown',
            ]);
        }
    }
}
