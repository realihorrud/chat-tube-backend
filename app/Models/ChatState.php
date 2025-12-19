<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\State;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property State $state
 * @property array<array-key, mixed> $last_update
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property int $chat_id
 * @property-read TelegramUser|null $user
 *
 * @method static Builder<static>|ChatState byChatId(int $chatId)
 * @method static Builder<static>|ChatState newModelQuery()
 * @method static Builder<static>|ChatState newQuery()
 * @method static Builder<static>|ChatState query()
 * @method static Builder<static>|ChatState whereChatId($value)
 * @method static Builder<static>|ChatState whereCreatedAt($value)
 * @method static Builder<static>|ChatState whereId($value)
 * @method static Builder<static>|ChatState whereLastUpdate($value)
 * @method static Builder<static>|ChatState whereState($value)
 * @method static Builder<static>|ChatState whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class ChatState extends Model
{
    protected $casts = [
        'state' => State::class,
        'last_update' => 'array',
    ];

    /**
     * @return BelongsTo<TelegramUser, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(TelegramUser::class, 'telegram_id', 'chat_id');
    }

    /**
     * @param  Builder<ChatState>  $query
     */
    #[Scope]
    protected function byChatId(Builder $query, int $chatId): void
    {
        $query->where('chat_id', $chatId);
    }
}
