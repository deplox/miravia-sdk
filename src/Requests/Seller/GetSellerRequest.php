<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Seller;

use Deplox\MiraviaSdk\Objects\Seller\Seller;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/seller/get
 */
final class GetSellerRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/seller/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return Seller::fromApiResponse($response->array('data') ?? []);
    }
}
