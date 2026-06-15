<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Seller;

use Deplox\MiraviaSdk\Objects\Seller\WarehouseCollection;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/rc/warehouse/get
 */
final class GetWarehousesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/rc/warehouse/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return WarehouseCollection::fromApiResponse($response->array('result.module') ?? []);
    }
}
