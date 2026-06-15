<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Product;

use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/brands/query
 */
final class GetBrandByMaxIdRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected ?int $maxId = null,
        protected ?int $pageSize = null,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'max_id' => $this->maxId,
            'page_size' => $this->pageSize,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/brands/query';
    }
}
