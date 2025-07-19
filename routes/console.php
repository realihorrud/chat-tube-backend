<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('set-webhook', function () {
    $response = Telegram::setWebhook(['url' => config('services.telegram.webhook_url')]);

    Log::channel('telegram')->info('Set Webhook: ', [$response]);

    return true;
});
