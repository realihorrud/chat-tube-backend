<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $duration
 * @property string $thumbnail_url
 * @property string $url
 * @property array<array-key, mixed> $items
 * @property int $youtube_video_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read YoutubeVideo|null $video
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereThumbnailUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereYoutubeVideoId($value)
 *
 * @mixin \Eloquent
 */
final class YoutubeVideoMedia extends Model
{
    protected $casts = [
        'items' => 'array',
    ];

    /**
     * @return BelongsTo<YoutubeVideo, $this>
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(YoutubeVideo::class);
    }
}
