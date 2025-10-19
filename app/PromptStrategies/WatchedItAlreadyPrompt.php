<?php

declare(strict_types=1);

namespace App\PromptStrategies;

final readonly class WatchedItAlreadyPrompt extends PromptStrategy
{
    public function getPromptKey(): string
    {
        return 'watched_it_already';
    }
}
