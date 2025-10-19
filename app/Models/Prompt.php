<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $key
 * @property string $label
 * @property string $value
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Prompt whereValue($value)
 *
 * @mixin \Eloquent
 */
final class Prompt extends Model {}
