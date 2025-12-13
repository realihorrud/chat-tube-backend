<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Author extends Dto
{
    public function __construct(
        public string $displayName,
        public Optional|string $username,
        public Optional|string $avatarUrl,
        public Optional|bool $verified,
    ) {}
}
