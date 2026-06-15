<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Concerns;

use Deplox\MiraviaSdk\Response;
use Closure;
use Generator;
use Illuminate\Support\Collection;
use Saloon\Http\Request;
use Saloon\Http\Response as SaloonResponse;
use Throwable;

/**
 * Fetch all pages of a paginated endpoint concurrently.
 *
 * Strategy: page 1 is sent synchronously so the request flows through
 * HasRetries — a stale access token is refreshed before any concurrent work
 * starts and the total is known. Pages 2..N are pooled at a controlled
 * concurrency; any pool failures are retried synchronously so they get the
 * full retry/token-refresh treatment too.
 *
 * @mixin \Deplox\MiraviaSdk\MiraviaConnector
 */
trait PaginatesRequests
{
    /**
     * @param  Closure(int $page): Request  $makeRequest  Build a Request for the given 1-based page number.
     * @param  Closure(Response $response): array{total: int, items: Collection<int, mixed>}  $readPage  Extract pagination meta + items from a response.
     * @return array{total: int, items: Collection<int, mixed>} Items across all pages, in page order.
     */
    public function paginate(
        Closure $makeRequest,
        Closure $readPage,
        int $pageSize,
        int $concurrency = 5,
    ): array {
        $firstPage = $readPage($this->send($makeRequest(1)));
        $total = $firstPage['total'];

        $lastPage = $pageSize > 0 ? (int) ceil($total / $pageSize) : 1;

        if ($lastPage <= 1) {
            return $firstPage;
        }

        /** @var array<int, Collection<int, mixed>> $pagesByIndex */
        $pagesByIndex = [1 => $firstPage['items']];
        $failedPages = [];

        $requests = function () use ($makeRequest, $lastPage): Generator {
            for ($page = 2; $page <= $lastPage; $page++) {
                yield $page => $makeRequest($page);
            }
        };

        $this->pool(
            requests: $requests,
            concurrency: $concurrency,
            responseHandler: function (SaloonResponse $response, int|string $page) use (&$pagesByIndex, &$failedPages, $readPage): void {
                try {
                    /** @var Response $response */
                    $pagesByIndex[(int) $page] = $readPage($response)['items'];
                } catch (Throwable) {
                    $failedPages[(int) $page] = true;
                }
            },
            exceptionHandler: function (mixed $reason, int|string $page) use (&$failedPages): void {
                $failedPages[(int) $page] = true;
            },
        )->send()->wait();

        foreach (array_keys($failedPages) as $page) {
            $pagesByIndex[$page] = $readPage($this->send($makeRequest($page)))['items'];
        }

        ksort($pagesByIndex);

        $items = new Collection;
        foreach ($pagesByIndex as $pageItems) {
            $items->push(...$pageItems->all());
        }

        return ['total' => $total, 'items' => $items];
    }
}
