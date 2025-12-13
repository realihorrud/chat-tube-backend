<?php

declare(strict_types=1);

namespace App\Supadata\Entities;

use Illuminate\Support\Collection;
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
        /** @var Collection<int, Content>|string $content */
        public readonly Collection|string $content,
        public readonly string $lang,
        public readonly array $availableLangs
    ) {}
}
