<?php

declare(strict_types=1);

namespace App\ValueObjects;

use InvalidArgumentException;

final readonly class YoutubeUrl
{
    private string $url;

    private function __construct(string $url)
    {
        $pattern = '((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?';

        if (! preg_match("/^$pattern$/", $url)) {
            throw new InvalidArgumentException('Youtube url is not valid.');
        }

        $this->url = $url;
    }

    public static function fromString(string $url): self
    {
        return new self($url);
    }

    public static function isValid(string $url): bool
    {
        try {
            new self($url);

            return true;
        } catch (InvalidArgumentException) {
            return false;
        }
    }

    public function value(): string
    {
        if (str_contains('http', $this->url)) {
            return $this->url;
        }

        return 'https://youtube.com/watch?v='.$this->url;
    }

    public function toUrl(): Url
    {
        return Url::fromString($this->url);
    }
}
