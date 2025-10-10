<?php

declare(strict_types=1);

namespace App\Telegram;

use App\Telegram\Entities\Message;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
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
        return Http::baseUrl($this->baseUrl)
            ->throw()
            ->get('getMe')
            ->json();
    }

    /**
     * @throws ConnectionException
     */
    public function setWebhook(): bool
    {
        return Http::baseUrl($this->baseUrl)
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
        return Http::baseUrl($this->baseUrl)
            ->throw()
            ->post('deleteWebhook')
            ->successful();
    }

    /**
     * @throws ConnectionException
     */
    public function getWebhookInfo(): array
    {
        return Http::baseUrl($this->baseUrl)
            ->throw()
            ->get('getWebhookInfo')
            ->json();
    }

    /**
     * @see https://core.telegram.org/bots/api#sendmessage
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
        $response = Http::baseUrl($this->baseUrl)
            ->throw()
            ->post('sendMessage', $params)
            ->json();

        return Message::from($response['result'] ?? []);
    }
}
