<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use OpenAI;

final class OpenAIProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(OpenAI\Client::class, function () {
            return OpenAI::client(config('services.open_ai.api_key'));
        });
    }
}
