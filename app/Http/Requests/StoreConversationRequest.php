<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\ValueObjects\YoutubeUrl;
use Illuminate\Foundation\Http\FormRequest;

final class StoreConversationRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'youtube_url' => ['required', 'string', 'url'],
        ];
    }

    public function youtubeUrl(): YoutubeUrl
    {
        return YoutubeUrl::fromString($this->validated('youtube_url'));
    }
}
