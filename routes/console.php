<?php

declare(strict_types=1);

use App\Telegram\TelegramBotApi;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('set-webhook', function (TelegramBotApi $api): bool {
    return $api->setWebhook();
});
