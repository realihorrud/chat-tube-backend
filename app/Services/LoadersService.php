<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ChatState\UpdateChatStateDTO;
use App\Models\ChatState;
use App\Telegram\Entities\Message;
use App\Telegram\TelegramBotApi;
use LogicException;
use Throwable;
use Webmozart\Assert\Assert;

final readonly class LoadersService
{
    public function __construct(private TelegramBotApi $api, private ChatStatesService $chatStatesService) {}

    /**
     * @throws Throwable
     */
    public function startProgress(string $text, int $chatId, bool $shouldSendNewMessage = true): void
    {
        $chatState = ChatState::byChatId($chatId)->first();

        if ($shouldSendNewMessage) {
            $message = $this->api->sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        } else {
            $message = $this->api->editMessageText([
                'chat_id' => $chatId,
                'message_id' => (int) $chatState->last_message_id,
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        }

        Assert::isInstanceOf($message, Message::class);

        $this->chatStatesService->update(
            chatState: $chatState,
            dto: UpdateChatStateDTO::from(['last_message_id' => $message->message_id, 'last_message' => $text])
        );

        usleep(1_500_000); // intended sleep for 1.5 seconds
    }

    /**
     * @throws Throwable
     */
    public function incrementLoadingBy(int $chatId, int $by = 10, int $times = 1): void
    {
        $chatState = ChatState::byChatId($chatId)->first();
        for ($i = 0; $i < $times; $i++) {
            $chatState->refresh();
            $progress = ((int) ($chatState->last_message) + $by).'%';

            $message = $this->api->editMessageText([
                'chat_id' => $chatId,
                'message_id' => (int) $chatState->last_message_id,
                'text' => $progress,
                'parse_mode' => 'Markdown',
            ]);

            if (! $message instanceof Message) {
                throw new LogicException('Not implemented yet.');
            }

            $this->chatStatesService->update($chatState, UpdateChatStateDTO::from([
                'last_message_id' => $message->message_id,
                'last_message' => $progress,
            ]));
        }
    }
}
