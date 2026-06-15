<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Resources;

use Deplox\MiraviaSdk\Requests\Fulfillment\GetShipmentProvidersRequest;
use Deplox\MiraviaSdk\Resource;
use Deplox\MiraviaSdk\Response;

final class FulfillmentApi extends Resource
{
    /**
     * @see https://open.miravia.com/apps/doc/api?path=/order/shipment/sof/providers/get
     */
    public function shipmentProviders(): Response
    {
        return $this->connector->send(
            new GetShipmentProvidersRequest
        );
    }
}
