<?php

declare(strict_types=1);

namespace App\Supadata\Services;

use App\Supadata\Entities\Transcript;
use App\Supadata\Entities\Video;
use App\ValueObjects\YoutubeUrl;
use App\ValueObjects\YoutubeVideoId;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

final readonly class YoutubeService
{
    public function __construct(
        #[Config('services.supadata.base_uri')]
        private string $baseUrl,
        #[Config('services.supadata.api_key')]
        private string $apiKey,
    ) {}

    /**
     * @see https://docs.supadata.ai/youtube/get-transcript
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    public function transcript(YoutubeUrl $url, ?string $lang = null, ?string $mode = null, bool $text = false): Transcript
    {
        $response = Http::baseUrl($this->baseUrl)->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get('youtube/transcript', [
            'url' => $url->value(),
            'lang' => $lang,
            'mode' => $mode,
            'text' => json_encode($text),
        ])->throw()->json();

        return Transcript::from($response);
    }

    /**
     * @see https://docs.supadata.ai/youtube/video
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    public function videoMetadata(YoutubeVideoId $videoId): Video
    {
        $response = Http::baseUrl($this->baseUrl)->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get('youtube/video', ['id' => $videoId->value()])->throw()->json();

        return Video::from($response);
    }
}
