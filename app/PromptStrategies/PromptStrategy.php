<?php

declare(strict_types=1);

namespace App\PromptStrategies;

use App\Models\Prompt;
use App\Models\User;
use App\Telegram\Entities\CallbackQuery;

abstract readonly class PromptStrategy
{
    abstract public function getPromptKey(): string;

    final public function run(CallbackQuery $callbackQuery): void
    {
        $userVideoRequest = User::query()
            ->firstWhere('telegram_id', $callbackQuery->from->id)
            ->videoRequests()
            ->latest()
            ->first();

        $prompt = Prompt::query()->firstWhere('key', $this->getPromptKey());
    }
}
