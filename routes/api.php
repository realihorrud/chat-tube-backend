<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\ConversationMessageController;
use App\Http\Middleware\ValidateWebAppData;
use Illuminate\Support\Facades\Route;

Route::middleware(ValidateWebAppData::class)->group(function (): void {
    Route::apiResource('chats', ConversationController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::apiResource('chats.messages', ConversationMessageController::class)->shallow()->only(['index', 'store']);
});
