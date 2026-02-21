<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\ConversationMessageController;
use App\Http\Middleware\ValidateWebAppData;
use Illuminate\Support\Facades\Route;

Route::middleware(ValidateWebAppData::class)->group(function (): void {
    Route::apiResource('conversations', ConversationController::class)->only(['index', 'store', 'show', 'destroy']);
    Route::patch('conversations/{conversation}/rename', [ConversationController::class, 'rename'])->name('conversations.rename');
    Route::post('conversations/{conversation}/pin', [ConversationController::class, 'pin'])->name('conversations.pin');
    Route::post('conversations/{conversation}/share', [ConversationController::class, 'share'])->name('conversations.share');
    Route::apiResource('conversations.messages', ConversationMessageController::class)->shallow()->only(['index', 'store']);
});

Route::get('conversations/{conversation}/shared', [ConversationController::class, 'sharedShow'])
    ->name('conversations.shared.show')
    ->middleware('signed');
