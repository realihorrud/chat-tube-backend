<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Location extends Dto
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public Optional|float $horizontal_accuracy,
        public Optional|int $live_period,
        public Optional|int $heading,
        public Optional|int $proximity_alert_radius,
    ) {}
}
