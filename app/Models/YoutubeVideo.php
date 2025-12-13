<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $vector_store_id
 * @property string $file_id
 * @property string $video_id
 * @property string $url
 * @property string|null $title
 * @property string|null $description
 * @property array<array-key, mixed> $tags
 * @property object $additional_data
 * @property string $uploaded_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read YoutubeVideoAuthor|null $author
 * @property-read YoutubeVideoMedia|null $media
 * @property-read YoutubeVideoStat|null $stats
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereAdditionalData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereUploadedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereVectorStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideo whereVideoId($value)
 *
 * @mixin \Eloquent
 */
final class YoutubeVideo extends Model
{
    protected $casts = [
        'tags' => 'array',
        'additional_data' => 'object',
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
}
