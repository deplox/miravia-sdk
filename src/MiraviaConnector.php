<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk;

use Deplox\MiraviaSdk\Concerns\HasCaching;
use Deplox\MiraviaSdk\Concerns\HasRateLimits;
use Deplox\MiraviaSdk\Concerns\HasRetries;
use Deplox\MiraviaSdk\Concerns\PaginatesRequests;
use Deplox\MiraviaSdk\Middlewares\SignRequest;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\Contracts\Sender;
use Saloon\Http\Connector;
use Saloon\Http\Response as SaloonResponse;
use Saloon\Http\Senders\GuzzleSender;

/**
 * @method \Deplox\MiraviaSdk\Response send($request, $mockClient = null, $handleRetry = null)
 * @method \GuzzleHttp\Promise\PromiseInterface sendAsync($request, $mockClient = null)
 */
class MiraviaConnector extends Connector implements Cacheable
{
    use HasCaching;
    use HasRateLimits;
    use HasRetries;
    use PaginatesRequests;

    protected ?string $response = Response::class;

    public function __construct(
        public readonly string $appKey,
        #[\SensitiveParameter] protected readonly string $secretKey,
        protected readonly string $signMethod,
        #[\SensitiveParameter] protected ?string $accessToken = null,
    ) {
        $this->tries = 3;
        $this->retryInterval = 2000;
        $this->useExponentialBackoff = true;
        $this->cachingEnabled = true;
        $this->rateLimitingEnabled = true;

        /*
         * Disable Saloon's built-in 429 detection. When enabled, Saloon throws a specialized
         * TooManyRequestsException after retries exhaust, which nothing in this codebase catches.
         * Real 429s are already handled via hasRequestFailed() (checks !$response->successful())
         * which routes them through the generic retry/failure path and surfaces a RequestException
         * that callers handle.
         */
        $this->detectTooManyAttempts = false;

        $this->middleware()->onRequest(
            new SignRequest($signMethod, $secretKey)
        );
    }

    public function resolveBaseUrl(): string
    {
        return (string) config('miravia.base_url');
    }

    /**
     * On failure, the Miravia API returns a 200 response status with an error code.
     * Also catches genuine HTTP errors (5xx, etc.) as a safety net.
     */
    public function hasRequestFailed(SaloonResponse $response): bool
    {
        return ! $response->successful() || $response->json('code') !== '0';
    }

    public function withAccessToken(#[\SensitiveParameter] ?string $accessToken): static
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    protected function defaultAuth(): MiraviaAuthenticator
    {
        return new MiraviaAuthenticator($this->appKey, $this->accessToken);
    }

    protected function defaultSender(): Sender
    {
        return resolve(GuzzleSender::class);
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultConfig(): array
    {
        return [
            'timeout' => (int) config('miravia.http_timeout'),
        ];
    }
}
