<?php

declare(strict_types=1);

namespace App\Resolvers;

use App\PromptStrategies\CustomPrompt;
use App\PromptStrategies\HaveNotWatchedItPrompt;
use App\PromptStrategies\MondayModePrompt;
use App\PromptStrategies\PromptStrategy;
use App\PromptStrategies\WatchedItAlreadyPrompt;
use App\Telegram\Entities\CallbackQuery;
use App\Telegram\TelegramBotApi;
use RuntimeException;
use Throwable;

final readonly class CallbackQueryResolver
{
    public function __construct(private TelegramBotApi $api) {}

    /**
     * @throws Throwable
     */
    public function resolve(CallbackQuery $callbackQuery): void
    {
        $className = match ($callbackQuery->data) {
            'watched_it_already' => WatchedItAlreadyPrompt::class,
            'haven\'t_watched_it' => HaveNotWatchedItPrompt::class,
            'monday_mode' => MondayModePrompt::class,
            'custom_prompt' => CustomPrompt::class,
            default => throw new RuntimeException('Undefined strategy for given callback data: '.$callbackQuery->data),
        };

        /** @var PromptStrategy|CustomPrompt $promptStrategy */
        $promptStrategy = app($className);

        $promptStrategy->run($callbackQuery);

        if ($promptStrategy instanceof PromptStrategy) {
            $this->sendWaitMessage($callbackQuery->message->chat->id, $callbackQuery->message->message_id);
        }
    }

    private function sendWaitMessage(int $chatId, int $messageId): void
    {
        $this->api->deleteMessages($chatId, $messageId--, $messageId);

        $this->api->sendMessage([
            'chat_id' => $chatId,
            'text' => '_loading..._',
            'parse_mode' => 'Markdown',
        ]);
    }
}
