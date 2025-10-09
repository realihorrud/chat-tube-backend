<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Venue extends Dto
{
    public function __construct(
        public Location $location,
        public string $title,
        public string $address,
        public Optional|string $foursquare_id,
        public Optional|string $foursquare_type,
        public Optional|string $google_place_id,
        public Optional|string $google_place_type,
    ) {}
}
