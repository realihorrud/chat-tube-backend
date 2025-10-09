<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Contracts\Debug\ShouldntReport;
use Illuminate\Http\JsonResponse;
use RuntimeException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;

abstract class BusinessException extends RuntimeException implements ShouldntReport
{
    public function __construct(public readonly int $chatId, string $message)
    {
        parent::__construct($message);
    }

    /**
     * @throws TelegramSDKException
     */
    final public function render(): JsonResponse
    {
        app(Api::class)->sendMessage([
            'chat_id' => $this->chatId,
            'text' => $this->getMessage(),
        ]);

        return response()->json(['message' => 'ok']);
    }
}
