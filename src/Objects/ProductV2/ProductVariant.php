<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ProductV2;

use Deplox\MiraviaSdk\Enums\ProductStatus;
use Deplox\MiraviaSdk\Objects\ProductV2\CountryPrice;
use Deplox\MiraviaSdk\Objects\ProductV2\WarehouseQuantity;
use Deplox\MiraviaSdk\Support\TextSanitizer;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

final readonly class ProductVariant implements Arrayable
{
    /**
     * @param  Collection<CountryPrice>  $prices
     * @param  Collection<WarehouseQuantity>  $quantities
     */
    public function __construct(
        public string $id,
        public string $eanCode,
        public string $shopSku,
        public string $sellerSku,
        public string $status,
        public ?string $subStatus,
        public ?string $rejectReason,
        public int $quantity,
        public float $price,
        public ?float $salePrice,
        public float $width,
        public float $length,
        public float $height,
        public float $weight,
        public ?string $packageContent,
        public ?string $aeStatus,
        public ?string $aeReason,
        public ?string $qcStatus,
        public ?string $qcReason,
        public ?Collection $images,
        public ?Collection $prices,
        public ?Collection $quantities,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        $images = new Collection($data['sku_images'] ?? []);
        $prices = new Collection($data['country_prices'] ?? []);
        $quantities = new Collection($data['warehouse_quantities'] ?? []);

        $qualityControlLog = $data['extra_info']['quality_control_log'] ?? [];

        return new self(
            $data['sku_id'],
            $data['ean_code'],
            $data['shop_sku'],
            $data['seller_sku'],
            ProductStatus::fromApiValue($data['status'] ?? ''),
            isset($data['sub_status']) && $data['sub_status'] !== '-' ? (string) $data['sub_status'] : null,
            isset($data['reject_reason']) && $data['reject_reason'] !== '-' ? TextSanitizer::clean((string) $data['reject_reason']) : null,
            $data['quantity'] ?? 0,
            (float) ($data['price'] ?? 0),
            isset($data['sale_price']) ? (float) $data['sale_price'] : null,
            (float) ($data['package_width'] ?? 0),
            (float) ($data['package_length'] ?? 0),
            (float) ($data['package_height'] ?? 0),
            (float) ($data['package_weight'] ?? 0),
            TextSanitizer::clean($data['package_content'] ?? null),
            $qualityControlLog['ae_status'] ?? null,
            TextSanitizer::clean($qualityControlLog['ae_reason'] ?? null),
            $qualityControlLog['qc_status'] ?? null,
            TextSanitizer::clean($qualityControlLog['qc_reason'] ?? null),
            $images->isEmpty() ? null
                : $images,
            $prices->isEmpty() ? null
                : $prices->transform(fn (array $item): CountryPrice => CountryPrice::fromApiResponse($item)),
            $quantities->isEmpty() ? null
                : $quantities->transform(fn (array $item): WarehouseQuantity => WarehouseQuantity::fromApiResponse($item)),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ean_code' => $this->eanCode,
            'shop_sku' => $this->shopSku,
            'seller_sku' => $this->sellerSku,
            'status' => $this->status,
            'sub_status' => $this->subStatus,
            'reject_reason' => $this->rejectReason,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'sale_price' => $this->salePrice,
            'width' => $this->width,
            'length' => $this->length,
            'height' => $this->height,
            'weight' => $this->weight,
            'package_content' => $this->packageContent,
            'ae_status' => $this->aeStatus,
            'ae_reason' => $this->aeReason,
            'qc_status' => $this->qcStatus,
            'qc_reason' => $this->qcReason,
            'images' => $this->images?->toArray(),
            'prices' => $this->prices?->toArray(),
            'quantities' => $this->quantities?->toArray(),
        ];
    }
}
