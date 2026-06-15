<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ProductV2;

use Deplox\MiraviaSdk\Enums\Country;
use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\ProductStatus;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/** @implements Arrayable<string, mixed> */
final readonly class MarketplaceStatus implements Arrayable
{
    public function __construct(
        public string $countryCode,
        public string $marketplaceCode,
        public string $status,
        public string $subStatus,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        $marketplace = Marketplace::fromApiValue(Str::before($data['platform'] ?? '', '_'));

        return new self(
            Country::fromApiValue($data['countryCode'] ?? ''),
            $marketplace,
            ProductStatus::fromApiValue($data['status'] ?? ''),
            ProductStatus::fromApiValue($data['subStatus'] ?? ''),
        );
    }

    public function toArray(): array
    {
        return [
            'country_code' => $this->countryCode,
            'marketplace_code' => $this->marketplaceCode,
            'status' => $this->status,
            'sub_status' => $this->subStatus,
        ];
    }
}
