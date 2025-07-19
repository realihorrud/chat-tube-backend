<?php

declare(strict_types=1);

use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post(sprintf('/%s/webhook', config('services.telegram.bot_token')), TelegramController::class)
    ->name('telegram.webhook');
