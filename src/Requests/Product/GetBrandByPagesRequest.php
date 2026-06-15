<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Product;

use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/category/brands/query
 */
final class GetBrandByPagesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected ?int $startRow = null,
        protected ?int $pageSize = null,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'start_row' => $this->startRow,
            'page_size' => $this->pageSize,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/category/brands/query';
    }
}
