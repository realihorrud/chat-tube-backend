<?php

declare(strict_types=1);

namespace App\ValueObjects;

use InvalidArgumentException;

final readonly class Url
{
    private string $url;

    private function __construct(string $url)
    {
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Url is not valid.');
        }

        $this->url = $url;
    }

    public static function fromString(string $url): self
    {
        return new self($url);
    }

    public function value(): string
    {
        return $this->url;
    }
}
