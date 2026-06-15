<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Orders;

use Deplox\MiraviaSdk\Objects\Orders\OrderCollection;
use Deplox\MiraviaSdk\Payloads\Orders\GetOrdersPayload;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/orders/get
 */
final class GetOrdersRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected GetOrdersPayload $payload,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'created_after' => $this->payload->createdAfter?->toIso8601String(),
            'created_before' => $this->payload->createdBefore?->toIso8601String(),
            'update_after' => $this->payload->updatedAfter?->toIso8601String(),
            'update_before' => $this->payload->updatedBefore?->toIso8601String(),
            'buyer_id' => $this->payload->buyerId,
            'country' => $this->payload->countryCode !== null ? strtoupper($this->payload->countryCode->value) : '',
            'status' => $this->payload->status?->value,
            'marketplace' => $this->payload->marketplace?->apiValue(),
            'sort_by' => $this->payload->sortBy?->value,
            'sort_direction' => $this->payload->sortDirection !== null ? strtoupper($this->payload->sortDirection->value) : '',
            'offset' => $this->payload->offset,
            'limt' => $this->payload->limit, // Not a typo — the Miravia API uses 'limt' instead of 'limit'
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/orders/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return OrderCollection::fromApiResponse($response->array('data'));
    }
}
