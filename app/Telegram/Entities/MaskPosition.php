<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;

final class MaskPosition extends Dto
{
    public function __construct(
        public string $point,
        public float $x_shift,
        public float $y_shift,
        public float $scale,
    ) {}
}
