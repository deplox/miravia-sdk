<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Seller;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

final readonly class WarehouseCollection implements Arrayable
{
    /**
     * @param  Collection<int, Warehouse>  $items
     */
    public function __construct(
        public Collection $items = new Collection,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            (new Collection($data))
                ->map(fn (array $item): Warehouse => Warehouse::fromApiResponse($item)),
        );
    }

    public function toArray(): array
    {
        return [
            'count' => $this->items->count(),
            'items' => $this->items->toArray(),
        ];
    }
}
