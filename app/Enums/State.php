<?php

declare(strict_types=1);

namespace App\Enums;

enum State: int
{
    case Idle = 0;
    case VideoProcessing = 1;
    case QuestionAsking = 2;
}
