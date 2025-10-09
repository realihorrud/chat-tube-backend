<?php

declare(strict_types=1);

use App\Http\Controllers\TelegramController;
use App\Http\Middleware\SetLocaleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post(sprintf('/%s/webhook', config('services.telegram.bot_token')), TelegramController::class)
    ->name('telegram.webhook')
    ->middleware(SetLocaleMiddleware::class);
