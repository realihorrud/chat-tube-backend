<?php

declare(strict_types=1);

namespace App\PromptStrategies;

use App\DTOs\UpdateUserVideoRequestDTO;
use App\Enums\UserStateStatus;
use App\Enums\UserVideoRequestStatus;
use App\Models\Prompt;
use App\Models\User;
use App\Models\UserVideoRequest;
use App\Services\UserStatesService;
use App\Telegram\Entities\CallbackQuery;
use App\Telegram\TelegramBotApi;

final readonly class CustomPrompt
{
    public function __construct(private TelegramBotApi $api, private UserStatesService $userStateService) {}

    public function run(CallbackQuery $callbackQuery): void
    {
        //        /** @var UserVideoRequest|null $userVideoRequest */
        //        $userVideoRequest = User::query()
        //            ->where('telegram_id', $callbackQuery->from->id)
        //            ->first()
        //            ->videoRequests()
        //            ->where('status', UserVideoRequestStatus::Pending->value)
        //            ->latest()
        //            ->first();
        //
        //        if (filled($userVideoRequest)) {
        //            $this->updateUserVideoRequestAction->run($userVideoRequest, UpdateUserVideoRequestDTO::from([
        //                'prompt' => Prompt::query()->firstWhere('key', $callbackQuery->data)->value,
        //            ]));
        //        }

        $this->api->sendMessage([
            'chat_id' => $callbackQuery->message->chat->id,
            'text' => 'Wow, look at you. Writing your own prompt. How ambitious.',
            'reply_markup' => ['force_reply' => true],
        ]);

        $this->userStateService->createUserState(
            telegramId: $callbackQuery->from->id,
            status: UserStateStatus::WaitingCustomPrompt,
        );
    }
}
