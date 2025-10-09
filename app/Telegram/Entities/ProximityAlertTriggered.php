<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class ProximityAlertTriggered extends Dto
{
    public function __construct(
        public User $traveler,
        public User $watcher,
        public int $distance,
    ) {}
}
