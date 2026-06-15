<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Product;

use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/product/item/get
 */
final class GetProductItemsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $id,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'item_id' => $this->id,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/product/item/get';
    }
}
