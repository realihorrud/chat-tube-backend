<?php

declare(strict_types=1);

namespace App\Supadata;

use App\Supadata\Services\YoutubeService;

final readonly class SupadataSdk
{
    public function youtube(): YoutubeService
    {
        return app(YoutubeService::class);
    }
}
