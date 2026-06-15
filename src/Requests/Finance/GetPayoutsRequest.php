<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Finance;

use Deplox\MiraviaSdk\Objects\Finance\PayoutStatusCollection;
use Deplox\MiraviaSdk\Request;
use Carbon\CarbonInterface;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/finance/payout/status/get
 */
final class GetPayoutsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected CarbonInterface $createdAfter,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'created_after' => $this->createdAfter->toIso8601String(),
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/finance/payout/status/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return PayoutStatusCollection::fromApiResponse($response->array('data') ?? []);
    }
}
