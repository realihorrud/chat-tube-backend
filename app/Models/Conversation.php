<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ConversationStatus;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $telegram_user_id
 * @property int|null $youtube_video_id
 * @property string|null $title
 * @property ConversationStatus $status
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read TelegramUser $telegramUser
 * @property-read YoutubeVideo|null $youtubeVideo
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Message> $messages
 *
 * @mixin \Eloquent
 */
final class Conversation extends Model
{
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
     * @return HasMany<Message, $this>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
