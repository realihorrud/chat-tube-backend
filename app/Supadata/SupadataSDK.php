<?php

declare(strict_types=1);

namespace App\Supadata;

use App\Supadata\Services\UniversalMetadataService;
use App\Supadata\Services\UniversalTranscriptService;
use App\Supadata\Services\WebService;
use App\Supadata\Services\YoutubeService;

final readonly class SupadataSDK
{
    public function universalTranscript(): UniversalTranscriptService
    {
        return app(UniversalTranscriptService::class);
    }

    public function universalMetadata(): UniversalMetadataService
    {
        return app(UniversalMetadataService::class);
    }

    public function youtube(): YoutubeService
    {
        return app(YoutubeService::class);
    }

    public function web(): WebService
    {
        return app(WebService::class);
    }
}
