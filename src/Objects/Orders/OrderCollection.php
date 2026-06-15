<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Orders;

use Deplox\MiraviaSdk\Objects\Orders\Order;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/** @implements Arrayable<string, mixed> */
final readonly class OrderCollection implements Arrayable
{
    /**
     * @param  Collection<int, Order>  $items
     */
    public function __construct(
        public int $total = 0,
        public Collection $items = new Collection,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        return new self(
            (int) $data['countTotal'],
            (new Collection($data['orders']))
                ->map(fn (array $item): Order => Order::fromApiResponse($item)),
        );
    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'count' => $this->items->count(),
            'items' => $this->items->toArray(),
        ];
    }
}
