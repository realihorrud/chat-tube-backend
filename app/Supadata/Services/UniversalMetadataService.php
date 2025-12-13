<?php

declare(strict_types=1);

namespace App\Supadata\Services;

use App\Supadata\Entities\Metadata;
use App\ValueObjects\Url;
use Illuminate\Container\Attributes\Config;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

final readonly class UniversalMetadataService
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
    public function getMetadata(Url $url): Metadata
    {
        $response = Http::baseUrl($this->baseUrl)->withHeaders([
            'x-api-key' => $this->apiKey,
        ])->get('metadata', ['url' => $url->value()])->throw()->json();

        return Metadata::from($response);
    }
}
