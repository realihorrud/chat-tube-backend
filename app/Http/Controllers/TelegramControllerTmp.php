<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\ProcessVideo;
use App\Resolvers\CallbackQueryResolver;
use App\Resolvers\CommandsResolver;
use App\Telegram\Entities\CallbackQuery;
use App\Telegram\Entities\Update;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Spatie\LaravelData\Optional;
use Throwable;
use Webmozart\Assert\Assert;

// Chain of Responsibility pattern

final readonly class TelegramControllerTmp
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        Request $request,
        CommandsResolver $commandsResolver,
        CallbackQueryResolver $callbackQueryResolver,
        TelegramBotApi $api,
    ): JsonResponse {
        $update = Update::from($request->all());

        if ($update->callback_query instanceof CallbackQuery) {
            $callbackQueryResolver->resolve($update->callback_query);

            return response()->json();
        }

        // If starts with slash than treat it as /command-name
        if (is_string($update->message->text) && str_starts_with($update->message->text, '/')) {
            $commandsResolver->resolve($update);

            return response()->json();
        }

        if (! $update->message->text instanceof Optional) {
            Assert::string($update->message->text);

            try {
                $api->sendMessage([
                    'chat_id' => $update->message->chat->id,
                    'text' => __('messages.video_processing'),
                    'parse_mode' => 'Markdown',
                ]);

                dispatch(new ProcessVideo(
                    chatId: $update->message->chat->id,
                    videoUrl: YoutubeUrl::fromString($update->message->text),
                ));

                return response()->json(['ok' => true]);
            } catch (InvalidArgumentException $exception) {
                $api->sendMessage([
                    'chat_id' => $update->message->chat->id,
                    'text' => $exception->getMessage(),
                ]);
            }
        }

        return response()->json(['ok' => true]);
    }
}
