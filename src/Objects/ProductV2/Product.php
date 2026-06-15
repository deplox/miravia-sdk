<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ProductV2;

use Deplox\MiraviaSdk\Enums\ProductStatus;
use Deplox\MiraviaSdk\Objects\ProductV2\MarketplaceStatus;
use Deplox\MiraviaSdk\Objects\ProductV2\ProductVariant;
use Deplox\MiraviaSdk\Support\TextSanitizer;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

/** @implements Arrayable<string, mixed> */
final readonly class Product implements Arrayable
{
    /**
     * @param  ?Collection<int, mixed>  $images
     * @param  ?Collection<int, MarketplaceStatus>  $statuses
     * @param  ?Collection<int, ProductVariant>  $variants
     */
    public function __construct(
        public int $id,
        public int $categoryId,
        public string $name,
        public string $brand,
        public string $status,
        public string $subStatus,
        public int $editLockStatus,
        public CarbonInterface $createdAt,
        public CarbonInterface $updatedAt,
        public ?Collection $images,
        public ?Collection $statuses,
        public ?Collection $variants,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        $images = new Collection($data['default_images'] ?? []);
        // merge miravia and aliexpress statuses
        $statuses = new Collection($data['country_level_status_list'] ?? [])
            ->push(...$data['ae_product_info']['country_level_status_list'] ?? []);
        $variants = new Collection($data['sku_data'] ?? []);

        return new self(
            (int) $data['product_id'],
            (int) $data['category_id'],
            TextSanitizer::clean($data['product_category_attribute_fields']['name'] ?? null) ?? '',
            TextSanitizer::clean($data['product_category_attribute_fields']['brand'] ?? null) ?? '',
            ProductStatus::fromApiValue($data['status'] ?? ''),
            ProductStatus::fromApiValue($data['sub_status'] ?? ''),
            (int) ($data['edit_lock_status'] ?? 0),
            Date::createFromTimestampMs($data['created_time']),
            Date::createFromTimestampMs($data['updated_time']),
            $images->isEmpty() ? null
                : $images,
            $statuses->isEmpty() ? null
                : $statuses->transform(fn (array $item): MarketplaceStatus => MarketplaceStatus::fromApiResponse($item)),
            $variants->isEmpty() ? null
                : $variants->transform(fn (array $item): ProductVariant => ProductVariant::fromApiResponse($item)),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->categoryId,
            'name' => $this->name,
            'brand' => $this->brand,
            'status' => $this->status,
            'sub_status' => $this->subStatus,
            'edit_lock_status' => $this->editLockStatus,
            'miravia_created_at' => (string) $this->createdAt,
            'miravia_updated_at' => (string) $this->updatedAt,
            'images' => $this->images?->toArray(),
            'statuses' => $this->statuses?->toArray(),
            'variants' => $this->variants?->toArray(),
        ];
    }
}
