<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Payloads\ProductV2;

use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\ProductStatus;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class GetProductPayload
{
    public function __construct(
        public ?array $ids = null,
        public ?array $skus = null,
        public ?Marketplace $marketplace = null,
        public ?ProductStatus $status = null,
        public ?int $page = null,
        public ?int $pageSize = null,
        public ?int $minCreatedAt = null,
        public ?int $maxCreatedAt = null,
        public ?string $language = null,
        public ?bool $showAllLanguages = null,
        public ?string $productIdCursor = null,
        public ?array $extraInfoFilter = null,
    ) {
        $this->ids = is_array($ids) ? array_values($ids) : null;
        $this->skus = is_array($skus) ? array_values($skus) : null;
        $this->extraInfoFilter = is_array($extraInfoFilter) ? array_values($extraInfoFilter) : null;
    }

    public static function fromArray(array $data): self
    {
        $rules = [
            'ids' => ['array'],
            'skus' => ['array'],
            'marketplace' => [Rule::enum(Marketplace::class)],
            'status' => [Rule::enum(ProductStatus::class)],
            'page' => ['integer', 'min:1'],
            'page_size' => ['integer', 'min:1', 'max:50'],
            'min_created_at' => ['integer', 'min:0'],
            'max_created_at' => ['integer', 'min:0'],
            'language' => ['string'],
            'show_all_languages' => ['boolean'],
            'product_id_cursor' => ['string'],
            'extra_info_filter' => ['array'],
        ];

        $attributes = array_fill_keys(array_keys($rules), null);

        foreach (Validator::validate($data, $rules) as $key => $value) {
            if ($key === 'marketplace') {
                $value = Marketplace::tryFrom($value);
            } elseif ($key === 'status') {
                $value = ProductStatus::tryFrom($value);
            } elseif (in_array($key, ['page', 'page_size', 'min_created_at', 'max_created_at'])) {
                $value = (int) $value;
            } elseif ($key === 'show_all_languages') {
                $value = (bool) $value;
            }

            $attributes[$key] = $value;
        }

        return new self(
            ids: $attributes['ids'],
            skus: $attributes['skus'],
            marketplace: $attributes['marketplace'],
            status: $attributes['status'],
            page: $attributes['page'],
            pageSize: $attributes['page_size'],
            minCreatedAt: $attributes['min_created_at'],
            maxCreatedAt: $attributes['max_created_at'],
            language: $attributes['language'],
            showAllLanguages: $attributes['show_all_languages'],
            productIdCursor: $attributes['product_id_cursor'],
            extraInfoFilter: $attributes['extra_info_filter'],
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
