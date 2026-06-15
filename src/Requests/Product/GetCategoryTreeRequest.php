<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Product;

use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/category/tree/get
 * @see https://open.miravia.com/apps/doc/doc?nodeId=138&docId=355
 */
final class GetCategoryTreeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $lang,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'language_code' => $this->lang,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/category/tree/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return $response->array('data');
    }
}
