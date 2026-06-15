<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Orders;

use Deplox\MiraviaSdk\Objects\Orders\Order;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/order/get
 */
final class GetOrderRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected int $id,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'order_id' => $this->id,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/order/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Order::fromApiResponse($response->array('data'));
    }
}
