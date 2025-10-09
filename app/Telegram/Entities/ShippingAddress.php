<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class ShippingAddress extends Dto
{
    public function __construct(
        public string $country_code,
        public string $state,
        public string $city,
        public string $street_line1,
        public string $street_line2,
        public string $post_code,
    ) {}
}
