<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ProductV2;

use Deplox\MiraviaSdk\Enums\Country;
use Illuminate\Contracts\Support\Arrayable;

/** @implements Arrayable<string, mixed> */
final readonly class CountryPrice implements Arrayable
{
    public function __construct(
        public string $countryCode,
        public float $price,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        return new self(
            Country::fromApiValue($data['country'] ?? ''),
            (float) $data['price'],
        );
    }

    public function toArray(): array
    {
        return [
            'country_code' => $this->countryCode,
            'price' => $this->price,
        ];
    }
}
