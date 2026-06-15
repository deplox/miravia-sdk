<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk;

use Illuminate\Support\ServiceProvider;
use Saloon\Http\Senders\GuzzleSender;

final class MiraviaSdkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/miravia.php', 'miravia');

        $this->app->singleton(GuzzleSender::class, fn (): GuzzleSender => new GuzzleSender);

        $this->app->singleton(MiraviaConnector::class, function (): MiraviaConnector {
            return new MiraviaConnector(
                appKey: (string) config('miravia.app_key'),
                secretKey: (string) config('miravia.secret_key'),
                signMethod: (string) config('miravia.sign_method', 'sha256'),
            );
        });

        $this->app->singleton(Miravia::class, fn (): Miravia => new Miravia(
            $this->app->make(MiraviaConnector::class)
        ));
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/miravia.php' => config_path('miravia.php'),
            ], 'miravia-config');
        }
    }
}
