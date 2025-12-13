<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\User\CreateOrUpdateUserAction;
use App\Handlers\CallbackHandler;
use App\Handlers\ClearCommandHandler;
use App\Handlers\NotFoundHandler;
use App\Handlers\StartCommandHandler;
use App\Handlers\YoutubeUrlHandler;
use App\Resolvers\CallbackQueryResolver;
use App\Telegram\ActualTelegramBotApi;
use App\Telegram\TelegramBotApi;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerHandlers();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModels();
        $this->configureDates();
        $this->configureUrls();
        $this->configureVite();
        $this->configurePasswordValidation();
        $this->configureServiceContainer();
    }

    private function configureServiceContainer(): void
    {
        $this->app->bind(TelegramBotApi::class, ActualTelegramBotApi::class);
    }

    /**
     * Configure the application's commands.
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction(),
        );
    }

    /**
     * Configure the application's dates.
     */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
    }

    /**
     * Configure the application's models.
     */
    private function configureModels(): void
    {
        Model::shouldBeStrict();
        Model::unguard();
    }

    /**
     * Configure the application's URLs.
     */
    private function configureUrls(): void
    {
        if ($this->app->environment('staging', 'production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Configure the application's Vite instance.
     */
    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    private function configurePasswordValidation(): void
    {
        Password::defaults(function () {
            return $this->app->environment('staging', 'production')
                ? Password::min(12)->uncompromised()
                : null;
        });
    }

    private function registerHandlers(): void
    {
        $this->app->singleton(YoutubeUrlHandler::class, function () {
            return new YoutubeUrlHandler($this->app->make(TelegramBotApi::class));
        });

        $this->app->singleton(StartCommandHandler::class, function () {
            return new StartCommandHandler(
                api: $this->app->make(TelegramBotApi::class),
                action: $this->app->make(CreateOrUpdateUserAction::class)
            );
        });

        $this->app->singleton(ClearCommandHandler::class, function () {
            return new ClearCommandHandler();
        });

        $this->app->singleton(CallbackHandler::class, function () {
            return new CallbackHandler($this->app->make(CallbackQueryResolver::class));
        });

        $this->app->singleton(NotFoundHandler::class, function () {
            return new NotFoundHandler();
        });
    }
}
