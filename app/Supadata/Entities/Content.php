<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use Spatie\LaravelData\Dto;

final class Content extends Dto
{
    public function __construct(
        public readonly string $text,
        public readonly float $offset,
        public readonly float $duration,
        public readonly string $lang,
    ) {}
}
