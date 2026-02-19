<?php

declare(strict_types=1);

namespace App\DTOs\YoutubeVideo;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class YoutubeVideoData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $video_id,
        public readonly string $url,
        public readonly ?string $title,
        public readonly string $description,
        /** @var array<array-key, mixed> */
        public readonly array $tags,
        public readonly string $uploaded_at,
        public readonly ?CarbonImmutable $created_at,
        public readonly ?CarbonImmutable $updated_at,
    ) {}
}
