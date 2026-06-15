<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Payloads\Product;

use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\ProductStatusRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class GetProductsPayload
{
    public function __construct(
        public ?array $ids = null,
        public ?array $skus = null,
        public ?Marketplace $marketplace = null,
        public ?ProductStatusRequest $status = null,
        public ?int $offset = null,
        public ?int $limit = null,
    ) {
        $this->ids = is_array($ids) ? array_values($ids) : null;
        $this->skus = is_array($skus) ? array_values($skus) : null;
    }

    public static function fromArray(array $data): self
    {
        $rules = [
            'ids' => ['array'],
            'skus' => ['array'],
            'marketplace' => [Rule::enum(Marketplace::class)],
            'status' => [Rule::enum(ProductStatusRequest::class)],
            'offset' => ['integer', 'multiple_of:10'],
            'limit' => ['integer', 'multiple_of:10', 'between:1,50'],
        ];

        $attributes = array_fill_keys(array_keys($rules), null);

        foreach (Validator::validate($data, $rules) as $key => $value) {
            if ($key === 'marketplace') {
                $value = Marketplace::tryFrom($value);
            } elseif ($key === 'status') {
                $value = ProductStatusRequest::tryFrom($value);
            } elseif (in_array($key, ['offset', 'limit'])) {
                $value = (int) $value;
            }

            $attributes[$key] = $value;
        }

        return new self(...array_values($attributes));
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
