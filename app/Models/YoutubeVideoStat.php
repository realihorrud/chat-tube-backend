<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $views
 * @property int $likes
 * @property int|null $shares
 * @property int|null $comments
 * @property int $youtube_video_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read YoutubeVideo|null $video
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat whereShares($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoStat whereYoutubeVideoId($value)
 *
 * @mixin \Eloquent
 */
final class YoutubeVideoStat extends Model
{
    /**
     * @return BelongsTo<YoutubeVideo, $this>
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(YoutubeVideo::class);
    }
}
