<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read User $user
 *
 * @method static Builder<static>|UserRequest newModelQuery()
 * @method static Builder<static>|UserRequest newQuery()
 * @method static Builder<static>|UserRequest query()
 * @method static Builder<static>|UserRequest whereCreatedAt($value)
 * @method static Builder<static>|UserRequest whereId($value)
 * @method static Builder<static>|UserRequest whereUpdatedAt($value)
 * @method static Builder<static>|UserRequest whereUserId($value)
 *
 * @mixin Eloquent
 */
final class UserRequest extends Model
{
    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
