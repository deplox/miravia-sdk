<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Fulfillment;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/** @implements Arrayable<string, mixed> */
final readonly class ShipmentProvider implements Arrayable
{
    /**
     * @param  Collection<int, Carrier>  $carriers
     */
    public function __construct(
        public string $name,
        public string $providerCode,
        public Collection $carriers,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        $carriers = new Collection;
        foreach ($data['carrier_info_list'] ?? [] as $carrier) {
            if (is_array($carrier)) {
                $carriers->push(Carrier::fromApiResponse($carrier));
            }
        }

        return new self(
            (string) ($data['name'] ?? ''),
            (string) ($data['provider_code'] ?? ''),
            $carriers,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'provider_code' => $this->providerCode,
            'carrier_info_list' => $this->carriers->toArray(),
        ];
    }
}
