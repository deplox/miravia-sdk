<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\ProductV2;

use Deplox\MiraviaSdk\Objects\ProductV2\ProductCollection;
use Deplox\MiraviaSdk\Payloads\ProductV2\GetProductPayload;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/v2/product/get
 */
final class GetProductRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected GetProductPayload $payload,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'product_ids' => $this->payload->ids ? json_encode($this->payload->ids) : null,
            'seller_skus' => $this->payload->skus ? json_encode($this->payload->skus) : null,
            'marketplace' => $this->payload->marketplace?->apiValue(),
            'status' => $this->payload->status?->value,
            'page' => $this->payload->page,
            'page_size' => $this->payload->pageSize,
            'min_created_at' => $this->payload->minCreatedAt,
            'max_created_at' => $this->payload->maxCreatedAt,
            'language' => $this->payload->language,
            'show_all_languages' => $this->payload->showAllLanguages,
            'product_id_cursor' => $this->payload->productIdCursor,
            'extraInfo_filter' => $this->payload->extraInfoFilter ? json_encode($this->payload->extraInfoFilter) : null,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/v2/product/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return ProductCollection::fromApiResponse($response->array());
    }
}
