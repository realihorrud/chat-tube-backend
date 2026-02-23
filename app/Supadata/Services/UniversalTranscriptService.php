<?php

declare(strict_types=1);

namespace App\Supadata\Services;

use App\Supadata\Entities\Error;
use App\Supadata\Entities\Transcript;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

final readonly class UniversalTranscriptService
{
    public function __construct(
        #[Config('services.supadata.base_uri')]
        private string $baseUrl,
        #[Config('services.supadata.api_key')]
        private string $apiKey,
    ) {}

    /**
     * @see https://docs.supadata.ai/get-transcript
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    public function getTranscript(
        YoutubeUrl $url,
        ?string $lang = null,
        ?string $mode = 'native',
        bool $text = false
    ): Error|Transcript|string {
        Log::channel('supadata')->info('Getting transcription for the video. YT URL: '.$url->value());

        $response = Http::timeout(240)->baseUrl($this->baseUrl)->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get('transcript', [
            'url' => $url->value(),
            'lang' => $lang,
            'mode' => $mode,
            'text' => json_encode($text),
        ])->throw();

        return match ($response->getStatusCode()) {
            Response::HTTP_PARTIAL_CONTENT => Error::from($response->json()),
            Response::HTTP_ACCEPTED => $response->json('jobId'),
            Response::HTTP_OK => Transcript::from($response->json()),
        };
    }

    /**
     * @see https://docs.supadata.ai/get-transcript#getting-job-results
     *
     * @throws ConnectionException
     * @throws RequestException
     */
    public function getJobResult(string $jobId): Error|Transcript
    {
        $response = Http::timeout(240)->baseUrl($this->baseUrl)->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get("transcript/$jobId")->throw();

        return match ($response->getStatusCode()) {
            Response::HTTP_OK => Transcript::from($response->json()),
        };
    }
}
