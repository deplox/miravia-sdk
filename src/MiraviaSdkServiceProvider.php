<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk;

use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Saloon\Http\Senders\GuzzleSender;

final class MiraviaSdkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(fn (): GuzzleSender => new GuzzleSender);

        $this->app->singleton(function (): MiraviaConnector {
            /** @var Repository $config */
            $config = $this->app->make('config');

            /** @var array<string,string> $credentials */
            $credentials = $config->array('miravia', []);

            return new MiraviaConnector(
                appKey: $credentials['app_key'] ?? '',
                secretKey: $credentials['secret_key'] ?? '',
                signMethod: $credentials['sign_method'] ?? 'sha256',
            );
        });
    }
}
