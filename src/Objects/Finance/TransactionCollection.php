<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Finance;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/** @implements Arrayable<string, mixed> */
final readonly class TransactionCollection implements Arrayable
{
    /**
     * @param  Collection<int, Transaction>  $items
     */
    public function __construct(
        public Collection $items = new Collection,
    ) {}

    /** @param array<int, array<string, mixed>> $data */
    public static function fromApiResponse(array $data): self
    {
        return new self(
            (new Collection($data))
                ->map(fn (array $item): Transaction => Transaction::fromApiResponse($item)),
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
