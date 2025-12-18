<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int $telegram_id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $username
 * @property string|null $language_code
 * @property-read ChatState|null $chatState
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser whereLanguageCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser whereTelegramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TelegramUser whereUsername($value)
 *
 * @mixin \Eloquent
 */
final class TelegramUser extends Model
{
    protected $table = 'telegram_users';

    /**
     * @return HasOne<ChatState, $this>
     */
    public function chatState(): HasOne
    {
        return $this->hasOne(ChatState::class, 'chat_id', 'telegram_id');
    }
}
