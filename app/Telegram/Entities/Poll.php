<?php

declare(strict_types=1);

namespace App\Telegram\Entities;

use Spatie\LaravelData\Dto;
use Spatie\LaravelData\Optional;

final class Poll extends Dto
{
    public function __construct(
        public string $id,
        public string $question,
        public Optional|array $question_entities,
        public array $options,
        public int $total_voter_count,
        public bool $is_closed,
        public bool $is_anonymous,
        public string $type,
        public bool $allows_multiple_answers,
        public Optional|int $correct_option_id,
        public Optional|string $explanation,
        public Optional|array $explanation_entities,
        public Optional|int $open_period,
        public Optional|int $close_date,
    ) {}
}
