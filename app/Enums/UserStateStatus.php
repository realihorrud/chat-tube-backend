<?php

declare(strict_types=1);

namespace App\Enums;

enum UserStateStatus: string
{
    case WaitingCustomPrompt = 'waiting_custom_prompt';
}
