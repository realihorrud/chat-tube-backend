<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $display_name
 * @property string|null $username
 * @property string|null $avatar_url
 * @property bool|null $verified
 * @property int $youtube_video_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read YoutubeVideo|null $video
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoAuthor whereYoutubeVideoId($value)
 *
 * @mixin \Eloquent
 */
final class YoutubeVideoAuthor extends Model
{
    protected $casts = [
        'verified' => 'boolean',
    ];

    /**
     * @return BelongsTo<YoutubeVideo, $this>
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(YoutubeVideo::class);
    }
}
