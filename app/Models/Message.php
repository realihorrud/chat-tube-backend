<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MessageRole;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $chat_id
 * @property MessageRole $role
 * @property string $content
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Conversation $chat
 *
 * @mixin \Eloquent
 */
final class Message extends Model
{
    protected $casts = [
        'role' => MessageRole::class,
    ];

    /**
     * @return BelongsTo<Conversation, $this>
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
