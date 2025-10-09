<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class RefundedPayment extends Dto
{
    public function __construct(
        public string $currency,
        public int $total_amount,
        public string $invoice_payload,
        public string $telegram_payment_charge_id,
        public Optional|string $provider_payment_charge_id,
    ) {}
}
