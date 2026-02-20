<?php

namespace App\Actions;

use App\Enums\MessageRole;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

final class CreateChatMessage
{
    public function handle(Chat $chat, string $answerContent): Message
    {
        return DB::transaction(function () use ($chat, $answerContent): Message {
            $message = new Message;
            $message->role = MessageRole::Assistant;
            $message->content = $answerContent;

            $chat->messages()->save($message);

            return $message;
        });
    }
}
