<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ConversationStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $telegram_user_id
 * @property string|null $youtube_video_id
 * @property string|null $title
 * @property ConversationStatus $status
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ConversationMessage> $conversationMessages
 * @property-read int|null $conversation_messages_count
 * @property-read TelegramUser $telegramUser
 * @property-read YoutubeVideo|null $youtubeVideo
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereTelegramUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Conversation whereYoutubeVideoId($value)
 *
 * @mixin \Eloquent
 */
final class Conversation extends Model
{
    use HasUuids;

    protected $casts = [
        'status' => ConversationStatus::class,
    ];

    /**
     * @return BelongsTo<TelegramUser, $this>
     */
    public function telegramUser(): BelongsTo
    {
        return $this->belongsTo(TelegramUser::class);
    }

    /**
     * @return BelongsTo<YoutubeVideo, $this>
     */
    public function youtubeVideo(): BelongsTo
    {
        return $this->belongsTo(YoutubeVideo::class);
    }

    /**
     * @return HasMany<ConversationMessage, $this>
     */
    public function conversationMessages(): HasMany
    {
        return $this->hasMany(ConversationMessage::class);
    }
}
