<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use Spatie\LaravelData\Dto;

/**
 * @see https://docs.supadata.ai/youtube/get-transcript
 */
final class Transcript extends Dto
{
    /**
     * @param  string[]  $availableLangs
     */
    public function __construct(
        public readonly string $content,
        public readonly string $lang,
        public readonly array $availableLangs
    ) {}
}
