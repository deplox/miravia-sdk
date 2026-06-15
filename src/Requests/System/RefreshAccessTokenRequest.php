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
 * @see https://open.miravia.com/apps/doc/api?path=/auth/token/refresh
 */
final class RefreshAccessTokenRequest extends Request implements HasBody
{
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $refreshToken,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'refresh_token' => $this->refreshToken,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/auth/token/refresh';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return AccessToken::fromApiResponse($response->array());
    }
}
