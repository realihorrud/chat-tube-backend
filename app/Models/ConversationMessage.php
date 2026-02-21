<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MessageRole;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $chat_id
 * @property MessageRole $role
 * @property string $content
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Conversation|null $conversation
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ConversationMessage whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class ConversationMessage extends Model
{
    use HasUuids;

    protected $casts = [
        'role' => MessageRole::class,
    ];

    /**
     * @return BelongsTo<Conversation, $this>
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
