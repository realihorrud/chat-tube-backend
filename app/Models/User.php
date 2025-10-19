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
 * @property-read UserSetting|null $settings
 * @property-read Collection<int, UserVideoRequest> $videoRequests
 * @property-read int|null $video_requests_count
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
     * @return HasMany<UserVideoRequest, $this>
     */
    public function videoRequests(): HasMany
    {
        return $this->hasMany(UserVideoRequest::class);
    }
}
