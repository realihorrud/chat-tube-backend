<?php

declare(strict_types=1);

namespace App\Telegram;

use App\Telegram\Entities\Message;

interface TelegramBotApi
{
    public function getMe(): array;

    public function setWebhook(): bool;

    public function deleteWebhook(): bool;

    public function getWebhookInfo(): array;

    /**
     * Implements https://core.telegram.org/bots/api#sendmessage
     *
     * @param array{
     *     chat_id:int|string,
     *     message_thread_id?:int,
     *     text:string,
     *     parse_mode?:string,
     *     entities?:array,
     *     link_preview_options?:array,
     *     disable_notification?:bool,
     *     protect_content?:bool,
     *     message_effect_id?:string,
     *     reply_parameters?:array,
     *     reply_markup?:array
     * } $params
     */
    public function sendMessage(array $params): Message;

    /**
     * @see https://core.telegram.org/bots/api#editmessagetext
     *
     * @param array{
     *     business_connection_id?: string,
     *     chat_id?: int|string,
     *     message_id?: int,
     *     inline_message_id?: string,
     *     text: string,
     *     parse_mode?: string,
     *     entities?:array,
     *     link_preview_options?:array,
     *     reply_markup?:array
     * } $params
     */
    public function editMessageText(array $params): Message|bool;

    /**
     * @see https://core.telegram.org/bots/api#deletemessage
     */
    public function deleteMessage(int $chatId, int $messageId): bool;

    /**
     * @see https://core.telegram.org/bots/api#deletemessages
     *
     * @param  int[]  $messageIds
     */
    public function deleteMessages(int $chatId, ...$messageIds): bool;
}
