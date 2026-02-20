<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\CreateChat;
use App\DTOs\Chat\ChatData;
use App\Http\Requests\StoreChatRequest;
use App\Models\Chat;
use App\Models\TelegramUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class ChatController
{
    public function index(Request $request): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');

        $chats = Chat::query()
            ->where('telegram_user_id', $telegramUser->id)
            ->with('youtubeVideo')
            ->latest()
            ->paginate();

        return response()->json(ChatData::collect($chats));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreChatRequest $request, CreateChat $createChat): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');

        $chat = $createChat->handle($telegramUser, $request->youtubeUrl());

        return response()->json(ChatData::from($chat->load('youtubeVideo', 'messages')), 201);
    }

    public function show(Request $request, Chat $chat): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($chat->telegram_user_id === $telegramUser->id, 403);

        return response()->json(ChatData::from($chat->load('youtubeVideo', 'messages')));
    }

    public function destroy(Request $request, Chat $chat): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($chat->telegram_user_id === $telegramUser->id, 403);

        $chat->delete();

        return response()->json(null, 204);
    }
}
