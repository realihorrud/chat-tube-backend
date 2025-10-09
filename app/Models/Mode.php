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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Mode whereValue($value)
 *
 * @mixin \Eloquent
 */
final class Mode extends Model {}
