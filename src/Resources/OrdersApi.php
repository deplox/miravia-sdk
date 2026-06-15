<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Resources;

use Deplox\MiraviaSdk\Payloads\Orders\GetOrdersPayload;
use Deplox\MiraviaSdk\Requests\Orders\GetMultipleOrderItemsRequest;
use Deplox\MiraviaSdk\Requests\Orders\GetOrderItemsRequest;
use Deplox\MiraviaSdk\Requests\Orders\GetOrderRequest;
use Deplox\MiraviaSdk\Requests\Orders\GetOrdersRequest;
use Deplox\MiraviaSdk\Resource;
use Deplox\MiraviaSdk\Response;

final class OrdersApi extends Resource
{
    /**
     * @see https://open.miravia.com/apps/doc/api?path=/orders/get
     */
    public function list(GetOrdersPayload $payload): Response
    {
        return $this->connector->send(
            new GetOrdersRequest($payload)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/order/get
     */
    public function get(int $id): Response
    {
        return $this->connector->send(
            new GetOrderRequest($id)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/order/items/get
     */
    public function getItems(int $id): Response
    {
        return $this->connector->send(
            new GetOrderItemsRequest($id)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/orders/items/get
     */
    public function getMultipleItems(array $ids): Response
    {
        return $this->connector->send(
            new GetMultipleOrderItemsRequest($ids)
        );
    }
}
