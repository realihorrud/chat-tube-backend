<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use Spatie\LaravelData\Dto;

final class Stats extends Dto
{
    public function __construct(
        public int $views,
        public ?int $likes,
        public ?int $shares,
        public ?int $comments,
    ) {}
}
