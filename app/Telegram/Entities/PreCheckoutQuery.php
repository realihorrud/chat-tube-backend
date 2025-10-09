<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class PreCheckoutQuery extends Dto
{
    public function __construct(
        public string $id,
        public User $from,
        public string $currency,
        public int $total_amount,
        public string $invoice_payload,
        public Optional|string $shipping_option_id,
        public Optional|OrderInfo $order_info,
    ) {}
}
