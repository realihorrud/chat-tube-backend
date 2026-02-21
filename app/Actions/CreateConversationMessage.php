<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\MessageRole;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

final class CreateConversationMessage
{
    public function handle(Conversation $chat, string $answerContent): Message
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
