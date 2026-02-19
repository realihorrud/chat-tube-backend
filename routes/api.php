<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Middleware\ValidateWebAppData;
use Illuminate\Support\Facades\Route;

Route::middleware(ValidateWebAppData::class)->group(function (): void {
    Route::apiResource('chats', ChatController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::apiResource('chats.messages', MessageController::class)->shallow()->only(['index', 'store']);
});
