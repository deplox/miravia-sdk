<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Finance;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

final readonly class PayoutStatusCollection implements Arrayable
{
    /**
     * @param  Collection<int, PayoutStatus>  $items
     */
    public function __construct(
        public Collection $items = new Collection,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            (new Collection($data))
                ->map(fn (array $item): PayoutStatus => PayoutStatus::fromApiResponse($item)),
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
