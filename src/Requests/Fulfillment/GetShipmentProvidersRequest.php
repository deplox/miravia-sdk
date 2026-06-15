<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Fulfillment;

use Deplox\MiraviaSdk\Objects\Fulfillment\ShipmentProviderCollection;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/order/shipment/sof/providers/get
 */
final class GetShipmentProvidersRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/order/shipment/sof/providers/get';
    }

    public function createDtoFromResponse(Response $response): ShipmentProviderCollection
    {
        return ShipmentProviderCollection::fromApiResponse(
            $response->array('result.data.shipment_providers') ?? []
        );
    }
}
