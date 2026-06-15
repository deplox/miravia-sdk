<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ProductV2;

use Deplox\MiraviaSdk\Enums\Country;
use Illuminate\Contracts\Support\Arrayable;

final readonly class CountryPrice implements Arrayable
{
    public function __construct(
        public string $countryCode,
        public float $price,
    ) {}

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
