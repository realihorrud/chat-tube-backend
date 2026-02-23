<?php

declare(strict_types=1);

namespace App\Models;

use App\Supadata\Enums\VideoTranscriptStatus;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string|null $vector_store_id
 * @property string|null $file_id
 * @property string $video_id
 * @property string $url
 * @property string|null $title
 * @property string $description
 * @property array<array-key, mixed> $tags
 * @property array<array-key, mixed> $additional_data
 * @property string|null $uploaded_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $conversation_id
 * @property string|null $status
 * @property string|null $job_id
 * @property-read YoutubeVideoAuthor|null $author
 * @property-read YoutubeVideoMedia|null $media
 * @property-read YoutubeVideoStat|null $stats
 *
 * @method static Builder<static>|YoutubeVideo latestUploadedVideo(int $conversationId)
 * @method static Builder<static>|YoutubeVideo newModelQuery()
 * @method static Builder<static>|YoutubeVideo newQuery()
 * @method static Builder<static>|YoutubeVideo query()
 * @method static Builder<static>|YoutubeVideo whereAdditionalData($value)
 * @method static Builder<static>|YoutubeVideo whereConversationId($value)
 * @method static Builder<static>|YoutubeVideo whereCreatedAt($value)
 * @method static Builder<static>|YoutubeVideo whereDescription($value)
 * @method static Builder<static>|YoutubeVideo whereFileId($value)
 * @method static Builder<static>|YoutubeVideo whereId($value)
 * @method static Builder<static>|YoutubeVideo whereJobId($value)
 * @method static Builder<static>|YoutubeVideo whereStatus($value)
 * @method static Builder<static>|YoutubeVideo whereTags($value)
 * @method static Builder<static>|YoutubeVideo whereTitle($value)
 * @method static Builder<static>|YoutubeVideo whereUpdatedAt($value)
 * @method static Builder<static>|YoutubeVideo whereUploadedAt($value)
 * @method static Builder<static>|YoutubeVideo whereUrl($value)
 * @method static Builder<static>|YoutubeVideo whereVectorStoreId($value)
 * @method static Builder<static>|YoutubeVideo whereVideoId($value)
 *
 * @mixin \Eloquent
 */
final class YoutubeVideo extends Model
{
    use HasUuids;

    protected $casts = [
        'tags' => 'array',
        'additional_data' => 'array',
        'status' => VideoTranscriptStatus::class,
    ];

    /**
     * @return HasOne<YoutubeVideoAuthor, $this>
     */
    public function author(): HasOne
    {
        return $this->hasOne(YoutubeVideoAuthor::class);
    }

    /**
     * @return HasOne<YoutubeVideoStat, $this>
     */
    public function stats(): HasOne
    {
        return $this->hasOne(YoutubeVideoStat::class);
    }

    /**
     * @return HasOne<YoutubeVideoMedia, $this>
     */
    public function media(): HasOne
    {
        return $this->hasOne(YoutubeVideoMedia::class);
    }

    /**
     * @param  Builder<YoutubeVideo>  $query
     */
    #[Scope]
    protected function latestUploadedVideo(Builder $query, int $conversationId): void
    {
        $query->where('conversation_id', $conversationId)->latest();
    }
}
