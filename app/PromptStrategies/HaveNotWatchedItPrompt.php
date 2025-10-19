<?php

declare(strict_types=1);

namespace App\PromptStrategies;

final readonly class HaveNotWatchedItPrompt extends PromptStrategy
{
    public function getPromptKey(): string
    {
        return 'haven\'t_watched_it';
    }
}
