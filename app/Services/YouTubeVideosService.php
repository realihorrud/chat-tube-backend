<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\YoutubeVideo;
use App\Supadata\Entities\Metadata;
use Illuminate\Support\Facades\DB;
use Throwable;

final class YouTubeVideosService
{
    /**
     * @throws Throwable
     */
    public function saveYoutubeVideo(string $vectorStoreId, string $fileId, Metadata $metadata): void
    {
        DB::transaction(function () use ($vectorStoreId, $fileId, $metadata): void {
            $youtubeVideo = new YoutubeVideo();
            $youtubeVideo->vector_store_id = $vectorStoreId;
            $youtubeVideo->file_id = $fileId;
            $youtubeVideo->video_id = $metadata->id;
            $youtubeVideo->url = $metadata->url;
            $youtubeVideo->title = $metadata->title;
            $youtubeVideo->description = $metadata->description;
            $youtubeVideo->tags = $metadata->tags;
            $youtubeVideo->additional_data = $metadata->additionalData;
            $youtubeVideo->uploaded_at = $metadata->createdAt;
            $youtubeVideo->save();
        });
    }
}
