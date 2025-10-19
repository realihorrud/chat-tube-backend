<?php

declare(strict_types=1);

namespace App\PromptStrategies;

final readonly class CustomPrompt extends PromptStrategy
{
    public function getPromptKey(): string
    {
        return '';
    }

    //    public function run(CallbackQuery $callbackQuery): void
    //    {
    //        /** @var UserVideoRequest|null $userVideoRequest */
    //        $userVideoRequest = User::query()
    //            ->where('telegram_id', $callbackQuery->from->id)
    //            ->first()
    //            ->videoRequests()
    //            ->where('status', UserVideoRequestStatus::Pending->value)
    //            ->latest()
    //            ->first();
    //        if (filled($userVideoRequest)) {
    //            $this->updateUserVideoRequestAction->run($userVideoRequest, UpdateUserVideoRequestDTO::from([
    //                'prompt' => Prompt::query()->firstWhere('key', $callbackQuery->data)->value,
    //            ]));
    //        }
    //
    //        $this->api->sendMessage([
    //            'chat_id' => $callbackQuery->message->chat->id,
    //            'text' => 'Wow, look at you. Writing your own prompt. How ambitious.',
    //            'reply_markup' => ['force_reply' => true],
    //        ]);
    //    }
}
