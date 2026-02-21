<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\AskQuestion;
use App\Actions\CreateConversationMessage;
use App\DTOs\Message\MessageData;
use App\Http\Requests\StoreConversationMessageRequest;
use App\Models\Conversation;
use App\Models\TelegramUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Responses\Responses\CreateStreamedResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

final class ConversationMessageController
{
    private const string RESPONSE_OUTPUT_TEXT_DELTA = 'response.output_text.delta';

    public function index(Request $request, Conversation $conversation): JsonResponse
    {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        $conversationMessages = $conversation->conversationMessages()->oldest()->paginate();

        return response()->json(MessageData::collect($conversationMessages));
    }

    /**
     * @throws Throwable
     */
    public function store(
        StoreConversationMessageRequest $request,
        Conversation $conversation,
        AskQuestion $askQuestion,
        CreateConversationMessage $createConversationMessage,
    ): StreamedResponse {
        /** @var TelegramUser $telegramUser */
        $telegramUser = $request->attributes->get('telegramUser');
        abort_unless($conversation->telegram_user_id === $telegramUser->id, 403);

        $stream = $askQuestion->handle($conversation, $request->validated('content'));

        return response()->stream(callback: function () use ($stream, $conversation, $createConversationMessage): void {
            $fullResponse = '';

            /** @var CreateStreamedResponse $chunk */
            foreach ($stream as $chunk) {
                if ($chunk->event === self::RESPONSE_OUTPUT_TEXT_DELTA) {
                    $fullResponse .= $chunk->response->delta;

                    $data = ['type' => 'content', 'content' => $chunk->response->delta];
                    echo 'data: '.json_encode($data)."\n\n";
                    flush();
                }
            }

            $data = ['type' => 'done', 'full_response' => $fullResponse];
            Log::channel('openai')->info('Stream completed: '.$fullResponse);
            echo 'data: '.json_encode($data)."\n\n";
            flush();

            $createConversationMessage->handle($conversation, $fullResponse);
        }, headers: [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no', // disable nginx buffering
        ]);
    }
}
