<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ProductV2;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
final readonly class WarehouseQuantity implements Arrayable
{
    public function __construct(
        public string $warehouseCode,
        public int $quantity,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        return new self(
            $data['warehouse_code'],
            (int) $data['quantity'],
        );
    }

    public function toArray(): array
    {
        return [
            'warehouse_code' => $this->warehouseCode,
            'quantity' => $this->quantity,
        ];
    }
}
