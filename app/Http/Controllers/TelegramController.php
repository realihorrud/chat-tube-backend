<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Resolvers\CommandsResolver;
use App\Telegram\Entities\Update;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final readonly class TelegramController
{
    public function __construct(
        private CommandsResolver $commandsResolver,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $update = Update::from($request->all());

        if (is_string($update->message->text) && str_starts_with($update->message->text, '/')) {
            $this->commandsResolver->resolve($update);
        }

        //        $foo = $this->telegram->sendMessage([
        //            'chat_id' => $relatedObject->chat_id,
        //            'text' => 'Choose the mode:',
        //        ]);
        //
        //        if ($relatedObject instanceof CallbackQuery) { // Callback from inline keyboard
        //            $text = $this->callbackActionStrategy->run($relatedObject);
        //
        //            $this->telegram->sendMessage([
        //                'chat_id' => $relatedObject->from->id,
        //                'text' => $text,
        //            ]);
        //
        //            return response()->json();
        //        }
        //
        //        if ($relatedObject instanceof Message && str_starts_with($relatedObject->text, '/')) { // Bot command, then skip it
        //            return response()->json();
        //        }
        //
        //        $response = $this->generateResponseAction->run(GenerateResponseDTO::fromMessage($relatedObject));
        //
        //        $this->telegram->sendMessage([
        //            'chat_id' => $relatedObject->chat->id,
        //            'text' => $response,
        //        ]);

        return response()->json(['ok' => true]);
    }
}
