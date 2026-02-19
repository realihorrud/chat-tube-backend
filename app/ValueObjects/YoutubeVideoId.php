<?php

declare(strict_types=1);

namespace App\ValueObjects;

use InvalidArgumentException;

final class YoutubeVideoId
{
    private string $id;

    private function __construct(string $videoId)
    {
        $pattern = '/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})(?:\S+)?$|^([a-zA-Z0-9_-]{11})$/';

        if (! preg_match($pattern, $videoId)) {
            throw new InvalidArgumentException('Youtube ID is not valid.');
        }

        $this->id = $videoId;
    }

    public static function fromString(string $videoId): self
    {
        return new self($videoId);
    }

    public function value(): string
    {
        return $this->id;
    }
}
