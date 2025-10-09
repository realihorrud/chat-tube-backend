<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class OrderInfo extends Dto
{
    public function __construct(
        public Optional|string $name,
        public Optional|string $phone_number,
        public Optional|string $email,
        public Optional|ShippingAddress $shipping_address,
    ) {}
}
