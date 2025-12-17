<?php

declare(strict_types=1);

namespace App\Supadata\Services;

use App\Supadata\Entities\Transcript;
use App\ValueObjects\YoutubeUrl;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

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
    public function getTranscript(YoutubeUrl $url, ?string $lang = null, ?string $mode = 'native', bool $text = false): Transcript
    {
        $response = Http::baseUrl($this->baseUrl)->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get('transcript', [
            'url' => $url->value(),
            'lang' => $lang,
            'mode' => $mode,
            'text' => json_encode($text),
        ])->throw()->json();

        return Transcript::from($response);
    }
}
