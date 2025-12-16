<?php

declare(strict_types=1);

use App\Telegram\TelegramBotApi;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (\OpenAI\Client $client): void {
    $this->comment(Inspiring::quote());
    dd(strlen(md5('Hello!')));
    echo
        $client->responses()->create(
            [
                'model' => 'gpt-4.1',
                'input' => 'Summarize the video about Brian Tracy.',
                'tools' => [['type' => 'file_search', 'vector_store_ids' => ['vs_69417157bfc88191bab3f51fc55301ad']]]
            ]
        )->outputText;
})->purpose('Display an inspiring quote');

Artisan::command('set-webhook', function (TelegramBotApi $api): bool {
    return $api->setWebhook();
});
