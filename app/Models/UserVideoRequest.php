<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserVideoRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $video_url
 * @property int $chat_id
 * @property string $status
 * @property int $user_id
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property string|null $prompt
 * @property int|null $message_id
 *
 * @method static \Database\Factories\UserVideoRequestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest wherePrompt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserVideoRequest whereVideoUrl($value)
 *
 * @mixin \Eloquent
 */
final class UserVideoRequest extends Model
{
    /** @use HasFactory<UserVideoRequestFactory> */
    use HasFactory;
}
