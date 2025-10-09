<?php

declare(strict_types=1);

namespace App\Supadata;

final readonly class TranscriptResult
{
    public function __construct(private array $responseData) {}

    public function text(): string
    {
        if (! empty($this->responseData['content'])) {
            if (is_string($this->responseData['content'])) {
                return $this->responseData['content'];
            }

            return implode(' ', $this->responseData['content']);
        }

        return '';
    }
}
