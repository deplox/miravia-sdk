<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Product;

use Deplox\MiraviaSdk\Payloads\Product\GetProductsPayload;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/products/get
 */
final class GetProductsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected GetProductsPayload $payload,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'item_id_list' => $this->payload->ids ? json_encode($this->payload->ids) : null,
            'sku_seller_list' => $this->payload->skus ? json_encode($this->payload->skus) : null,
            'marketplace' => $this->payload->marketplace?->apiValue(),
            'filter' => $this->payload->status?->apiValue(),
            'offset' => $this->payload->offset,
            'limit' => $this->payload->limit,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/products/get';
    }
}
