<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Handlers\CallbackHandler;
use App\Handlers\StartCommandHandler;
use App\Handlers\TextHandler;
use App\Handlers\YoutubeUrlHandler;
use App\Models\ChatState;
use App\Telegram\Entities\Update;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Sentry\Laravel\Facade;
use Throwable;

final readonly class TelegramController
{
    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $handler = app(YoutubeUrlHandler::class);

            $handler
                ->setNextHandler(app(StartCommandHandler::class))
                ->setNextHandler(app(CallbackHandler::class))
                ->setNextHandler(app(TextHandler::class));

            $update = Update::from($request->all());

            $handler->handle($update, ChatState::byChatId($update->message->chat->id)->first());
        } catch (Throwable $e) {
            Facade::captureException($e);

            Log::error($e->getMessage().PHP_EOL.$e->getTraceAsString());
        } finally {
            return response()->json(['ok' => true]);
        }
    }
}
