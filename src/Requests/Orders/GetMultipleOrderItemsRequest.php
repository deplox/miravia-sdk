<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Orders;

use Deplox\MiraviaSdk\Objects\Orders\OrderItem;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/orders/items/get
 */
final class GetMultipleOrderItemsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected array $ids,
    ) {
        $this->ids = array_values($ids);
    }

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'order_ids' => json_encode($this->ids),
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/orders/items/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        $orders = $response->collect('data');

        $items = $orders->flatMap(function (array $order): array {
            return array_map(
                fn (array $item): OrderItem => OrderItem::fromApiResponse($item),
                $order['order_items'],
            );
        });

        return $items;
    }
}
