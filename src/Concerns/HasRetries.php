<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Concerns;

use Illuminate\Support\Facades\Log;
use Monolog\Level;
use Monolog\Logger;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Request;

/**
 * @mixin \Deplox\MiraviaSdk\MiraviaConnector
 */
trait HasRetries
{
    /**
     * The callback that should be used to handle the retry.
     *
     * @var (\Closure(FatalRequestException|RequestException, Request): bool)|null
     */
    public static $handleRetryCallback;

    /**
     * Set a callback that should be used when handling the retry.
     *
     * @param  \Closure(FatalRequestException|RequestException, Request): bool  $callback
     */
    public static function handleRetryUsing(\Closure $callback): void
    {
        static::$handleRetryCallback = $callback;
    }

    public function handleRetry(FatalRequestException|RequestException $exception, Request $request): bool
    {
        $shouldRetry = static::$handleRetryCallback
            ? call_user_func(static::$handleRetryCallback, $exception, $request)
            : parent::handleRetry($exception, $request);

        $logger = Log::getLogger();

        if ($logger instanceof Logger && $logger->isHandling(Level::Debug)) {
            Log::debug('Miravia request retry decision', [
                'request' => $request::class,
                'exception' => $exception::class,
                'message' => $exception->getMessage(),
                'http_status' => $exception instanceof RequestException ? $exception->getResponse()->status() : null,
                'api_code' => $exception instanceof RequestException ? $exception->getResponse()->json('code') : null,
                'will_retry' => $shouldRetry,
            ]);
        }

        return $shouldRetry;
    }
}
