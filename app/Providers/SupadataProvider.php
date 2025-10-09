<?php

declare(strict_types=1);

namespace App\Providers;

use App\Supadata\SupadataSDK;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

final class SupadataProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(SupadataSDK::class)
            ->needs(Client::class)
            ->give(function () {
                return new Client([
                    'base_uri' => config('services.supadata.base_uri'),
                    'headers' => [
                        'x-api-key' => config('services.supadata.api_key'),
                    ],
                ]);
            });
    }
}
