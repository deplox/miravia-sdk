<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ReturnAndRefund;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

final readonly class ReversalCollection implements Arrayable
{
    /**
     * @param  Collection<int, Reversal>  $items
     */
    public function __construct(
        public int $total = 0,
        public int $pageNo = 1,
        public int $pageSize = 10,
        public Collection $items = new Collection,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        return new self(
            total: (int) ($data['total'] ?? 0),
            pageNo: (int) ($data['page_no'] ?? 1),
            pageSize: (int) ($data['page_size'] ?? 10),
            items: (new Collection($data['items'] ?? []))
                ->map(fn (array $item): Reversal => Reversal::fromApiResponse($item)),
        );
    }

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'page_no' => $this->pageNo,
            'page_size' => $this->pageSize,
            'count' => $this->items->count(),
            'items' => $this->items->toArray(),
        ];
    }
}
