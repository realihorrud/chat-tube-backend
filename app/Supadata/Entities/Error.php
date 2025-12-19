<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use Spatie\LaravelData\Dto;

final class Error extends Dto
{
    public function __construct(
        public readonly string $error,
        public readonly string $message,
        public readonly string $details,
        public readonly string $documentationUrl,
    ) {}

    public function getMessage(string $locale): string
    {
        return __('supadata.errors.'.str_replace('-', '_', $this->error), locale: $locale);
    }
}
