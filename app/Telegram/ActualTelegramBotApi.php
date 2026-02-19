<?php

declare(strict_types=1);

namespace App\Telegram;

use App\Telegram\Entities\Message;
use Exception;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Uri;

final readonly class ActualTelegramBotApi implements TelegramBotApi
{
    public function __construct(
        #[Config('services.telegram.api_url')]
        private string $baseUrl
    ) {}

    /**
     * @return array<string, array<string, int|string|bool>>
     *
     * @throws ConnectionException
     */
    public function getMe(): array
    {
        return Http::timeout(240)->baseUrl($this->baseUrl)
            ->throw()
            ->get('getMe')
            ->json();
    }

    /**
     * @throws ConnectionException
     */
    public function setWebhook(): bool
    {
        return Http::timeout(240)->baseUrl($this->baseUrl)
            ->throw()
            ->post('setWebhook', [
                'url' => Uri::of(route('telegram.webhook')),
            ])
            ->successful();
    }

    /**
     * @throws ConnectionException
     */
    public function deleteWebhook(): bool
    {
        return Http::timeout(240)->baseUrl($this->baseUrl)
            ->throw()
            ->post('deleteWebhook')
            ->successful();
    }

    /**
     * @throws ConnectionException
     */
    public function getWebhookInfo(): array
    {
        return Http::timeout(240)->baseUrl($this->baseUrl)
            ->throw()
            ->get('getWebhookInfo')
            ->json();
    }

    /**
     * @see https://core.telegram.org/bots/api#sendmessage
     *
     * {@inheritdoc}
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
     *
     * @throws ConnectionException
     */
    public function sendMessage(array $params): Message
    {
        $response = Http::timeout(240)->baseUrl($this->baseUrl)
            ->throw()
            ->post('sendMessage', $params)
            ->json();

        return Message::from($response['result'] ?? []);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMessage(int $chatId, int $messageId): bool
    {
        try {
            Http::timeout(240)->baseUrl($this->baseUrl)
                ->throw()
                ->post('deleteMessage', ['chat_id' => $chatId, 'message_id' => $messageId])
                ->json();

            return true;
        } catch (Exception $e) {
            Log::error(
                message: $e->getMessage(),
                context: ['chat_id' => $chatId, 'message_id' => $messageId],
            );

            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMessages(int $chatId, ...$messageIds): bool
    {
        foreach ($messageIds as $messageId) {
            $this->deleteMessage($chatId, $messageId);
        }

        return true;
    }

    /**
     * @see https://core.telegram.org/bots/api#editmessagetext
     *
     * @throws ConnectionException
     */
    public function editMessageText(array $params): Message|bool
    {
        $response = Http::timeout(240)->baseUrl($this->baseUrl)
            ->throw()
            ->post('editMessageText', $params)
            ->json();

        if (is_bool($response['result'])) {
            return $response['result'];
        }

        return Message::from($response['result']);
    }
}
