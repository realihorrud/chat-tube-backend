<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property int $telegram_id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $username
 * @property string|null $language_code
 * @property-read Collection<int, UserRequest> $requests
 * @property-read int|null $requests_count
 * @property-read UserSetting|null $settings
 *
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereFirstName($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereLanguageCode($value)
 * @method static Builder<static>|User whereLastName($value)
 * @method static Builder<static>|User whereTelegramId($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User whereUsername($value)
 *
 * @mixin Eloquent
 */
final class User extends Model
{
    /**
     * @return HasOne<User, $this>
     */
    public function settings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    /**
     * @return HasMany<UserRequest, $this>
     */
    public function requests(): HasMany
    {
        return $this->hasMany(UserRequest::class);
    }
}
