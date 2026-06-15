<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Tests;

use Deplox\MiraviaSdk\MiraviaSdkServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [MiraviaSdkServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('miravia.base_url', 'https://api.miravia.test');
        $app['config']->set('miravia.app_key', 'test-app-key');
        $app['config']->set('miravia.secret_key', 'test-secret-key');
        $app['config']->set('miravia.sign_method', 'sha256');
        $app['config']->set('miravia.http_timeout', 30);
        $app['config']->set('miravia.cache_expiry_seconds', 300);
        $app['config']->set('miravia.access_token_refresh_threshold_days', 7);
        $app['config']->set('cache.default', 'array');
    }
}
