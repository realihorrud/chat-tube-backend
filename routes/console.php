<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

Artisan::command('inspire', function (): void {
    dd(Telegram::getMe());
})->purpose('Display an inspiring quote');

Artisan::command('set-webhook', function () {
    $response = Telegram::setWebhook(['url' => config('services.telegram.webhook_url')]);

    Log::channel('telegram')->info('Set Webhook: ', [$response]);

    return true;
});
