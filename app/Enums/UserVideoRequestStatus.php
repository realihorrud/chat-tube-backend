<?php

declare(strict_types=1);

namespace App\Enums;

enum UserVideoRequestStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Completed = 'completed';
    case Rejected = 'rejected';
}
