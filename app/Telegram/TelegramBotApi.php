<?php

declare(strict_types=1);

namespace App\Telegram;

interface TelegramBotApi
{
    public function getMe(): array;

    public function setWebhook(): bool;

    public function deleteWebhook(): bool;

    public function getWebhookInfo(): array;
}
