<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use App\Entities\Entity;

final class Video extends Entity
{
    /**
     * @param  array{id: string, name: string}  $channel
     * @param  string[]  $tags
     * @param  string[]  $transcriptLanguages
     */
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $description,
        public readonly int $duration,
        public readonly array $channel,
        public readonly array $tags,
        public readonly string $thumbnail,
        public readonly string $uploadDate,
        public readonly int $viewCount,
        public readonly int $likeCount,
        public readonly array $transcriptLanguages,
    ) {}
}
