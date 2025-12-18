<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use App\Supadata\Enums\PlatformEnum;
use App\Supadata\Enums\TypeEnum;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Metadata extends Dto
{
    public function __construct(
        public TypeEnum $type,
        public PlatformEnum $platform,
        public string $id,
        public string $url,
        public ?string $title,
        public ?string $description,
        public Author $author,
        public Stats $stats,
        public Media $media,
        /** @var string[] $tags */
        public array $tags,
        public Optional|string $createdAt,
        /** @var array<string, mixed> $additionalData */
        public array $additionalData,
    ) {}
}
