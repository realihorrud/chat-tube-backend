<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Enums\State;
use App\Jobs\AskAIQuestionJob;
use App\Models\ChatState;
use App\Telegram\Entities\Message;
use App\Telegram\Entities\Update;

final class TextHandler extends Handler
{
    public function handle(Update $update, ?ChatState $state): void
    {
        if ($update->message instanceof Message) {
            switch ($state->state) {
                case State::Idle:
                case State::ProcessingVideo:
                    break; // Do nothing for now
                case State::QuestionAsking:
                    dispatch(new AskAIQuestionJob($update->message->chat->id, $update->message->text));
                    break;
            }

            return;
        }

        parent::handle($update, $state);
    }
}
