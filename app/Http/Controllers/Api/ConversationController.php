<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\StartConversation;
use App\DTOs\Conversation\ConversationData;
use App\Http\Requests\RenameConversationRequest;
use App\Http\Requests\StoreConversationRequest;
use App\Models\Conversation;
use App\Models\TelegramUser;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Throwable;

final readonly class ConversationController
{
    public function __construct(
        #[Config('services.telegram.mini_app_url')]
        private string $miniAppUrl,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');

        $conversations = Conversation::query()
            ->where('telegram_user_id', $telegramUser->id)
            ->with('youtubeVideo')
            ->orderByDesc('order')
            ->latest()
            ->paginate();

        return response()->json(ConversationData::collect($conversations));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreConversationRequest $request, StartConversation $createChat): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');

        $conversation = $createChat->handle($telegramUser, $request->youtubeUrl());

        return response()->json(
            data: ConversationData::from($conversation->load('youtubeVideo', 'conversationMessages'))->include(
                'messages'
            ),
            status: 201,
        );
    }

    public function show(Request $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        return response()->json(
            ConversationData::from($conversation->load('youtubeVideo', 'conversationMessages'))->include('*')
        );
    }

    public function destroy(Request $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        $conversation->delete();

        return response()->json(null, 204);
    }

    public function rename(RenameConversationRequest $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        $conversation->title = $request->validated('title');
        $conversation->save();

        return response()->json(ConversationData::from($conversation));
    }

    public function pin(Request $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        $conversation->order = $conversation->order > 0
            ? 0
            : Conversation::query()->where('telegram_user_id', $telegramUser->id)->max('order') + 1;

        $conversation->save();

        return response()->json(ConversationData::from($conversation));
    }

    public function share(Request $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        $signedPath = URL::signedRoute('conversations.shared.show', ['conversation' => $conversation->id]);
        $signature = str_replace('signature=', '', parse_url($signedPath, PHP_URL_QUERY));

        $shareUrl = sprintf($this->miniAppUrl . '?startapp=c_%s_%s', $conversation->id, $signature);

        return response()->json(['url' => $shareUrl]);
    }

    public function sharedShow(Conversation $conversation): JsonResponse
    {
        return response()->json(
            ConversationData::from($conversation->load('youtubeVideo', 'conversationMessages'))->include('*')
        );
    }
}
