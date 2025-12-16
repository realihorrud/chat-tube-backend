<?php

declare(strict_types=1);

namespace App\Models;

use App\Supadata\Entities\Item;
use App\Supadata\Enums\TypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int|null $duration
 * @property string|null $thumbnail_url
 * @property string|null $url
 * @property Collection<int, Item> $items
 * @property int $youtube_video_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property TypeEnum $type
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|YoutubeVideoMedia whereYoutubeVideoId($value)
 *
 * @mixin \Eloquent
 */
final class YoutubeVideoMedia extends Model
{
    protected $casts = [
        'type' => TypeEnum::class,
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
