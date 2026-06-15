<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\LaravelCacheDriver;
use Saloon\CachePlugin\Traits\HasCaching as HasCachingPlugin;
use Saloon\Http\PendingRequest;

/**
 * @mixin \Deplox\MiraviaSdk\MiraviaConnector|\Saloon\CachePlugin\Traits\HasCaching
 */
trait HasCaching
{
    use HasCachingPlugin;

    /**
     * Blanket TTL applied to every cacheable request on the connector.
     *
     * Acceptable today because all callers are background fetch jobs — none of the
     * endpoints currently in use serve real-time data (stock, inventory, live pricing).
     * If a low-latency endpoint is added, override `cacheExpiryInSeconds()` on that
     * Request class, or disable caching on the PendingRequest, rather than lowering
     * this value globally.
     */
    public function cacheExpiryInSeconds(): int
    {
        return (int) config('miravia.cache_expiry_seconds');
    }

    public function resolveCacheDriver(): Driver
    {
        /** @var string $store */
        $store = config('cache.default');

        return new LaravelCacheDriver(Cache::store($store));
    }

    /**
     * @throws \JsonException
     */
    protected function cacheKey(PendingRequest $pendingRequest): string
    {
        $requestUrl = $pendingRequest->getUrl();
        $query = Arr::except($pendingRequest->query()->all(), ['sign_method', 'timestamp', 'sign']);

        return json_encode(compact('requestUrl', 'query'), JSON_THROW_ON_ERROR);
    }
}
