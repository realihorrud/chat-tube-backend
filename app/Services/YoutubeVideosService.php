<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\YoutubeVideo\YoutubeVideoDTO;
use App\Models\YoutubeVideo;
use App\Models\YoutubeVideoAuthor;
use App\Models\YoutubeVideoMedia;
use App\Models\YoutubeVideoStat;
use App\Supadata\Entities\Author;
use App\Supadata\Entities\Media;
use App\Supadata\Entities\Stats;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Optional;
use Throwable;

final class YoutubeVideosService
{
    /**
     * @throws Throwable
     */
    public function saveYoutubeVideo(YoutubeVideoDTO $dto): YoutubeVideo
    {
        return DB::transaction(function () use ($dto): YoutubeVideo {
            $youtubeVideo = new YoutubeVideo();
            $youtubeVideo->chat_id = $dto->chat_id;
            $youtubeVideo->vector_store_id = $dto->vector_store_id;
            $youtubeVideo->file_id = $dto->file_id;
            $youtubeVideo->video_id = $dto->metadata->id;
            $youtubeVideo->url = $dto->metadata->url;
            $youtubeVideo->title = $dto->metadata->title;
            $youtubeVideo->description = $dto->metadata->description;
            $youtubeVideo->tags = $dto->metadata->tags;
            $youtubeVideo->additional_data = $dto->metadata->additionalData;
            $youtubeVideo->uploaded_at = $dto->metadata->createdAt instanceof Optional ? null : $dto->metadata->createdAt;
            $youtubeVideo->save();

            $this->saveVideoStats($youtubeVideo, $dto->metadata->stats);
            $this->saveVideoAuthor($youtubeVideo, $dto->metadata->author);
            $this->saveVideoMedia($youtubeVideo, $dto->metadata->media);

            return $youtubeVideo;
        });
    }

    /**
     * @throws Throwable
     */
    private function saveVideoStats(YoutubeVideo $youtubeVideo, Stats $stats): void
    {
        DB::transaction(function () use ($youtubeVideo, $stats): void {
            $model = new YoutubeVideoStat();
            $model->views = $stats->views;
            $model->likes = $stats->likes;
            $model->comments = $stats->comments;
            $model->shares = $stats->shares;
            $youtubeVideo->stats()->save($model);
        });
    }

    /**
     * @throws Throwable
     */
    private function saveVideoAuthor(YoutubeVideo $youtubeVideo, Author $author): void
    {
        DB::transaction(function () use ($youtubeVideo, $author): void {
            $model = new YoutubeVideoAuthor();
            $model->display_name = $author->displayName;
            $model->username = $author->username instanceof Optional ? null : $author->username;
            $model->avatar_url = $author->avatarUrl instanceof Optional ? null : $author->avatarUrl;
            $model->verified = $author->verified instanceof Optional ? null : $author->verified;
            $youtubeVideo->author()->save($model);
        });
    }

    /**
     * @throws Throwable
     */
    private function saveVideoMedia(YoutubeVideo $youtubeVideo, Media $media): void
    {
        DB::transaction(function () use ($youtubeVideo, $media): void {
            $model = new YoutubeVideoMedia();
            $model->type = $media->type;
            $model->duration = $media->duration instanceof Optional ? null : $media->duration;
            $model->thumbnail_url = $media->thumbnailUrl instanceof Optional ? null : $media->thumbnailUrl;
            $model->url = $media->url instanceof Optional ? null : $media->url;
            /** @phpstan-ignore-next-line */
            $model->items = $media->items instanceof Optional ? null : $media->items;
            $youtubeVideo->media()->save($model);
        });
    }
}
