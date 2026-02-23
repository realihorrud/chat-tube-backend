<?php

declare(strict_types=1);

namespace App\Supadata\Enums;

enum VideoTranscriptStatus: string
{
    case Queued = 'queued';
    case Active = 'active';
    case Completed = 'completed';
    case Failed = 'failed';
}
