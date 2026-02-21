<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\MessageRole;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use Illuminate\Support\Facades\DB;

final class CreateConversationMessage
{
    public function handle(Conversation $conversation, string $answerContent): ConversationMessage
    {
        return DB::transaction(function () use ($conversation, $answerContent): ConversationMessage {
            $conversationMessage = new ConversationMessage;
            $conversationMessage->role = MessageRole::Assistant;
            $conversationMessage->content = $answerContent;

            $conversation->conversationMessages()->save($conversationMessage);

            return $conversationMessage;
        });
    }
}
