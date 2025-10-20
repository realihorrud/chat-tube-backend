<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Telegram\ChoosePromptAction;
use App\Actions\UserVideoRequest\StoreUserVideoRequestAction;
use App\DTOs\StoreUserVideoRequestDTO;
use App\Models\User;
use App\Resolvers\CallbackQueryResolver;
use App\Resolvers\CommandsResolver;
use App\Telegram\Entities\CallbackQuery;
use App\Telegram\Entities\Update;
use App\Telegram\TelegramBotApi;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Spatie\LaravelData\Optional;
use Throwable;
use Webmozart\Assert\Assert;

final readonly class TelegramController
{
    /**
     * @throws Throwable
     */
    public function __invoke(
        Request $request,
        CommandsResolver $commandsResolver,
        CallbackQueryResolver $callbackQueryResolver,
        TelegramBotApi $api,
        ChoosePromptAction $choosePromptAction,
        StoreUserVideoRequestAction $storeUserVideoRequestAction
    ): JsonResponse {
        $update = Update::from($request->all());

        Log::info(
            message: 'update object',
            context: $update->toArray(),
        );

        // TODO: $update->message->from is Optional!
        if (! $update->message->from->is_bot) {
            $user = User::query()->firstWhere('telegram_id', $update->message->from->id);
            if ($user->states()->exists()) {
                Log::info('user state is: ', [$user->states()->first()->state]);
            }
        }

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
                YoutubeUrl::fromString($update->message->text);

                $storeUserVideoRequestAction->run(StoreUserVideoRequestDTO::fromUpdate($update));
                $choosePromptAction->handle($update->message->chat->id);

                return response()->json();
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
