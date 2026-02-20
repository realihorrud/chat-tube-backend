<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\AskQuestion;
use App\Actions\CreateChatMessage;
use App\DTOs\Message\MessageData;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Chat;
use App\Models\TelegramUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

final class MessageController
{
    public function index(Request $request, Chat $chat): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($chat->telegram_user_id === $telegramUser->id, 403);

        $messages = $chat->messages()->oldest()->paginate();

        return response()->json(MessageData::collect($messages));
    }

    /**
     * @throws Throwable
     */
    public function store(
        StoreMessageRequest $request,
        Chat $chat,
        AskQuestion $askQuestion,
        CreateChatMessage $createChatMessage,
    ): StreamedResponse {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($chat->telegram_user_id === $telegramUser->id, 403);

        $stream = $askQuestion->handle($chat, $request->validated('content'));

        return new StreamedResponse(function () use ($stream) {
            $messageId = null;

            foreach ($stream as $chunk) {
                // TODO: look for response.output_text.delta to emit event-stream
                // TODO: store a message in DB on response.output_text.done

                if (!$messageId && isset($chunk['id'])) {
                    $messageId = $chunk['id'];
                }

                echo "data: " . json_encode([
                        'id' => $messageId,
                        'delta' => $chunk['delta'],
                        'created_at' => $chunk['created_at'] ?? null,
                    ]) . "\n\n";

                ob_flush();
                flush();
            }

            ob_flush();
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no', // disables nginx buffering
            'Connection' => 'keep-alive',
        ]);
    }
}
