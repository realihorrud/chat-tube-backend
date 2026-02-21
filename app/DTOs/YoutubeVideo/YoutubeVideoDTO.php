<?php

declare(strict_types=1);

namespace App\DTOs\YoutubeVideo;

use App\Supadata\Entities\Metadata;
use Spatie\LaravelData\Dto;

final class YoutubeVideoDTO extends Dto
{
    public function __construct(
        public readonly string $vector_store_id,
        public readonly string $file_id,
        public readonly string $chat_id,
        public readonly Metadata $metadata,
    ) {}
}
