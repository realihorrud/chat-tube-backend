<?php

declare(strict_types=1);

namespace App\Exceptions;

final class CouldNotGenerateResponseException extends BusinessException
{
    private function __construct(int $chatId, string $message)
    {
        parent::__construct($chatId, $message);
    }

    public static function becauseYoutubeUrlIsNotValid(int $chatId): self
    {
        return new self($chatId, __('exceptions.response.youtube_url_is_not_valid'));
    }

    public static function becauseOfSupadataError(int $chatId, string $message): self
    {
        return new self($chatId, $message);
    }
}
