<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Fulfillment;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

final readonly class ShipmentProviderCollection implements Arrayable
{
    /**
     * @param  Collection<int, ShipmentProvider>  $items
     */
    public function __construct(
        public Collection $items = new Collection,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            (new Collection($data))
                ->filter(fn (mixed $item): bool => is_array($item))
                ->values()
                ->map(fn (array $item): ShipmentProvider => ShipmentProvider::fromApiResponse($item)),
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
