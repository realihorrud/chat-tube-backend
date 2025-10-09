<?php

declare(strict_types=1);

namespace App\Supadata;

use App\Supadata\Services\Youtube;
use GuzzleHttp\Client;

final readonly class SupadataSDK
{
    public function __construct(private Client $client) {}

    public function youtube(): Youtube
    {
        return new Youtube($this->client);
    }
}
