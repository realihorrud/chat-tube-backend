<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\StartConversation;
use App\DTOs\Conversation\ConversationData;
use App\Http\Requests\StoreConversationRequest;
use App\Models\Conversation;
use App\Models\TelegramUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class ConversationController
{
    public function index(Request $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');

        $chats = Conversation::query()
            ->where('telegram_user_id', $telegramUser->id)
            ->with('youtubeVideo')
            ->latest()
            ->paginate();

        return response()->json(ConversationData::collect($chats));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreConversationRequest $request, StartConversation $createChat): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');

        $conversation = $createChat->handle($telegramUser, $request->youtubeUrl());

        return response()->json(ConversationData::from($conversation->load('youtubeVideo', 'conversationMessages')), 201);
    }

    public function show(Request $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        return response()->json(ConversationData::from($conversation->load('youtubeVideo', 'conversationMessages'))->include('*'));
    }

    public function destroy(Request $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        $conversation->delete();

        return response()->json(null, 204);
    }
}
