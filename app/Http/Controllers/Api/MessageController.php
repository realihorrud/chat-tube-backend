<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\AskQuestionAction;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Chat;
use App\Models\TelegramUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class MessageController
{
    public function index(Request $request, Chat $chat): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($chat->telegram_user_id === $telegramUser->id, 403);

        $messages = $chat->messages()->oldest()->paginate();

        return response()->json($messages);
    }

    /**
     * @throws Throwable
     */
    public function store(StoreMessageRequest $request, Chat $chat, AskQuestionAction $askQuestion): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($chat->telegram_user_id === $telegramUser->id, 403);

        $assistantMessage = $askQuestion->handle($chat, $request->validated('content'));

        return response()->json($assistantMessage, 201);
    }
}
