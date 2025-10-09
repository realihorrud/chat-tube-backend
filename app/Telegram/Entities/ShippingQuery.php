<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class ShippingQuery extends Dto
{
    public function __construct(
        public string $id,
        public User $from,
        public string $invoice_payload,
        public ShippingAddress $shipping_address,
    ) {}
}
