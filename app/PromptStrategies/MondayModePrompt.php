<?php

declare(strict_types=1);

namespace App\PromptStrategies;

final readonly class MondayModePrompt extends PromptStrategy
{
    public function getPromptKey(): string
    {
        return 'monday_mode';
    }
}
