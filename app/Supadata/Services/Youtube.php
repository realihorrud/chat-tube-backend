<?php

declare(strict_types=1);

namespace App\Supadata\Services;

use App\Supadata\TranscriptResult;
use App\ValueObjects\YoutubeUrl;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use RuntimeException;

final readonly class Youtube
{
    public function __construct(private Client $client) {}

    public function transcript(YoutubeUrl $url, ?string $lang = null, ?string $mode = null): TranscriptResult
    {
        try {
            $result = $this->client->request('GET', 'youtube/transcript', [
                'query' => [
                    'url' => $url->value(),
                    'lang' => $lang,
                    'mode' => $mode,
                    'text' => json_encode(true),
                ],
            ])->getBody()->getContents();

            $response = json_decode($result, true);

            if (! empty($response['error'])) {
                Log::channel('api')->error($e->getMessage());

                throw new RuntimeException($response['message']);
            }

            return new TranscriptResult($response);
        } catch (GuzzleException $e) {
            Log::channel('api')->error($e->getMessage());

            return new TranscriptResult([]);
        }
    }
}
