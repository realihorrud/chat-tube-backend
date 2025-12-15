<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Contracts\Debug\ShouldntReport;
use RuntimeException;

abstract class BusinessException extends RuntimeException implements ShouldntReport
{
    public function __construct(public readonly int $chatId, string $message)
    {
        parent::__construct($message);
    }
}
