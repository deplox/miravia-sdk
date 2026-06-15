<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\System;

use Deplox\MiraviaSdk\Objects\System\AccessToken;
use Deplox\MiraviaSdk\Request;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasFormBody;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/auth/token/create
 */
final class GenerateAccessTokenRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $code,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'code' => $this->code,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/auth/token/create';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return AccessToken::fromApiResponse($response->array());
    }
}
