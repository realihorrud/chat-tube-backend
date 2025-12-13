<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use App\Supadata\Enums\TypeEnum;
use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Item extends Dto
{
    public function __construct(
        public TypeEnum $type,
        public Optional|int $duration,
        public Optional|string $thumbnailUrl,
        public Optional|string $url,
    ) {}
}
