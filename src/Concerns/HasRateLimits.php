<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Concerns;

use Deplox\MiraviaSdk\Exceptions\RateLimitReachedException;
use Illuminate\Support\Facades\Cache;
use Saloon\Http\Request;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits as HasRateLimitsPlugin;

/**
 * @mixin \Deplox\MiraviaSdk\MiraviaConnector|\Saloon\RateLimitPlugin\Traits\HasRateLimits
 */
trait HasRateLimits
{
    use HasRateLimitsPlugin {
        getLimiterPrefix as protected protectedGetLimiterPrefix;
    }

    /**
     * The callback that should be used to get the limiter prefix.
     *
     * @var (\Closure(\Deplox\MiraviaSdk\MiraviaConnector): ?string)|null
     */
    public static $getLimiterPrefixCallback;

    /**
     * Set a callback that should be used when getting the limiter prefix.
     *
     * @param  \Closure(\Deplox\MiraviaSdk\MiraviaConnector): ?string  $callback
     */
    public static function getLimiterPrefixUsing(\Closure $callback): void
    {
        static::$getLimiterPrefixCallback = $callback;
    }

    protected function getLimiterPrefix(): ?string
    {
        if (static::$getLimiterPrefixCallback) {
            return call_user_func(static::$getLimiterPrefixCallback, $this);
        }

        return $this->protectedGetLimiterPrefix();
    }

    /** @return array<int, Limit> */
    protected function resolveLimits(): array
    {
        return [
            Limit::allow(100)->everyMinute(),
            Limit::allow(1000)->everyDay(),
        ];
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        /** @var string $store */
        $store = config('cache.default');

        return new LaravelCacheStore(Cache::store($store));
    }

    protected function handleTooManyAttempts(Request $request, Limit $limit): never
    {
        throw new RateLimitReachedException($limit);
    }
}
