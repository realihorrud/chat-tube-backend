<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserStateStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property UserStateStatus $state
 * @property int $user_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserState newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserState newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserState query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserState whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserState whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserState whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserState whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserState whereUserId($value)
 *
 * @mixin \Eloquent
 */
final class UserState extends Model
{
    protected $casts = [
        'state' => UserStateStatus::class,
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
