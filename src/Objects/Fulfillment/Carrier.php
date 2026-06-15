<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Fulfillment;

use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
final readonly class Carrier implements Arrayable
{
    public function __construct(
        public ?string $carrierName,
        public ?string $carrierCode,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        return new self(
            isset($data['carrier_name']) ? (string) $data['carrier_name'] : null,
            isset($data['carrier_code']) ? (string) $data['carrier_code'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'carrier_name' => $this->carrierName,
            'carrier_code' => $this->carrierCode,
        ];
    }
}
