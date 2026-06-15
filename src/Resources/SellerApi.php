<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Resources;

use Deplox\MiraviaSdk\Requests\Seller\GetSellerRequest;
use Deplox\MiraviaSdk\Requests\Seller\GetWarehousesRequest;
use Deplox\MiraviaSdk\Resource;
use Deplox\MiraviaSdk\Response;

final class SellerApi extends Resource
{
    /**
     * @see https://open.miravia.com/apps/doc/api?path=/seller/get
     * @see https://open.miravia.com/apps/doc/doc?nodeId=30685&docId=120929
     */
    public function get(): Response
    {
        return $this->connector->send(
            new GetSellerRequest
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/rc/warehouse/get
     */
    public function warehouses(): Response
    {
        return $this->connector->send(
            new GetWarehousesRequest
        );
    }
}
