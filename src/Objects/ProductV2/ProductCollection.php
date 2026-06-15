<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ProductV2;

use Deplox\MiraviaSdk\Objects\ProductV2\Product;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/** @implements Arrayable<string, mixed> */
final readonly class ProductCollection implements Arrayable
{
    /**
     * @param  Collection<int, Product>  $items
     */
    public function __construct(
        public int $count,
        public int $total,
        public Collection $items,
        public int $page = 1,
        public int $pageSize = 0,
        public int $totalPage = 0,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        return new self(
            count: count($data['data']),
            total: (int) ($data['total_product'] ?? 0),
            items: (new Collection($data['data']))
                ->map(fn (array $item): Product => Product::fromApiResponse($item)),
            page: (int) ($data['page'] ?? 1),
            pageSize: (int) ($data['page_size'] ?? 0),
            totalPage: (int) ($data['total_page'] ?? 0),
        );
    }

    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'total' => $this->total,
            'page' => $this->page,
            'page_size' => $this->pageSize,
            'total_page' => $this->totalPage,
            'items' => $this->items->toArray(),
        ];
    }
}
