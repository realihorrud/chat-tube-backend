<?php

declare(strict_types=1);

namespace App\Supadata\Enums;

enum PlatformEnum: string
{
    case Youtube = 'youtube';
    case Instagram = 'instagram';
    case TikTok = 'tiktok';
    case Twitter = 'twitter';
    case Facebook = 'facebook';
}
