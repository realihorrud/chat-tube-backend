<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int $telegram_id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $username
 * @property string|null $language_code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Conversation> $conversations
 * @property-read int|null $conversations_count
 *
 * @method static Builder<static>|TelegramUser byChatId(int $chatId)
 * @method static Builder<static>|TelegramUser newModelQuery()
 * @method static Builder<static>|TelegramUser newQuery()
 * @method static Builder<static>|TelegramUser query()
 * @method static Builder<static>|TelegramUser whereCreatedAt($value)
 * @method static Builder<static>|TelegramUser whereFirstName($value)
 * @method static Builder<static>|TelegramUser whereId($value)
 * @method static Builder<static>|TelegramUser whereLanguageCode($value)
 * @method static Builder<static>|TelegramUser whereLastName($value)
 * @method static Builder<static>|TelegramUser whereTelegramId($value)
 * @method static Builder<static>|TelegramUser whereUpdatedAt($value)
 * @method static Builder<static>|TelegramUser whereUsername($value)
 *
 * @mixin \Eloquent
 */
final class TelegramUser extends Model
{
    use HasUuids;

    protected $table = 'telegram_users';

    /**
     * @return HasMany<Conversation, $this>
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * @param  Builder<TelegramUser>  $query
     */
    #[Scope]
    protected function byChatId(Builder $query, int $chatId): void
    {
        $query->where('telegram_id', $chatId);
    }
}
