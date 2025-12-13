<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Handlers\CallbackHandler;
use App\Handlers\ClearCommandHandler;
use App\Handlers\NotFoundHandler;
use App\Handlers\StartCommandHandler;
use App\Handlers\YoutubeUrlHandler;
use App\Telegram\Entities\Update;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final readonly class TelegramController
{
    /**
     * @throws Throwable
     */
    public function __invoke(Request $request): JsonResponse
    {
        // CoR pattern ✅
        // State pattern
        // 1. User sends YouTube video link. ✅
        // 1.1 Tell the user that we are processing the video. ✅
        // 2. We get the transcript. ✅
        // 3. We create a vector representation of the transcript. ✅
        // 3.1 Create a TEXT file with transcript. ✅
        // 4. We store metadata about the video and id of vector representation which represents that video. ✅
        // 5. We reply to user with the following message: "Video has been processed. Ask anything about this video!" ✅
        // 5.1 State should be implemented here at this point...
        // 6. User keeps asking questions until /clear command...
        // 6.1 Create a clear command handler...

        $handler = app(YoutubeUrlHandler::class)
            ->setNextHandler(app(StartCommandHandler::class))
            ->setNextHandler(app(ClearCommandHandler::class))
            ->setNextHandler(app(CallbackHandler::class))
            ->setNextHandler(app(NotFoundHandler::class));

        $handler->handle(Update::from($request->all()));

        return response()->json(['ok' => true]);
    }
}
