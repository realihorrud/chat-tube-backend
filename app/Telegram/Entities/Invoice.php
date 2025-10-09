<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class Invoice extends Dto
{
    public function __construct(
        public string $title,
        public string $description,
        public string $start_parameter,
        public string $currency,
        public int $total_amount,
    ) {}
}
