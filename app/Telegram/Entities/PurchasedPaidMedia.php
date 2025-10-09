<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class PurchasedPaidMedia extends Dto
{
    public function __construct(
        public User $from,
        public string $paid_media_payload,
    ) {}
}
