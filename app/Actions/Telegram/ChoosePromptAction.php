<?php

declare(strict_types=1);

namespace App\Actions\Telegram;

use App\Models\Prompt;
use App\Telegram\Entities\InlineKeyboardButton;
use App\Telegram\Entities\InlineKeyboardMarkup;
use App\Telegram\TelegramBotApi;

final readonly class ChoosePromptAction
{
    public function __construct(private TelegramBotApi $api) {}

    public function handle(int $chatId): void
    {
        $inlineKeyboard = [];
        foreach (Prompt::all() as $prompt) {
            $inlineKeyboard[][] = InlineKeyboardButton::from([
                'text' => $prompt->label,
                'callback_data' => $prompt->key,
            ]);
        }

        $inlineKeyboard[][] = InlineKeyboardButton::from([
            'text' => 'Add your own custom prompt',
            'callback_data' => 'custom_prompt',
        ]);

        $this->api->sendMessage([
            'chat_id' => $chatId,
            'text' => __('messages.choose_mode'),
            'reply_markup' => InlineKeyboardMarkup::from([
                'inline_keyboard' => $inlineKeyboard,
            ])->toArray(),
        ]);
    }
}
