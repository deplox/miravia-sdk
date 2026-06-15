<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Payloads\Orders;

use Deplox\MiraviaSdk\Enums\Country;
use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\OrderStatus;
use Deplox\MiraviaSdk\Enums\SortDirection;
use Deplox\MiraviaSdk\Enums\SortTimestamp;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class GetOrdersPayload
{
    public function __construct(
        public ?CarbonInterface $createdAfter = null,
        public ?CarbonInterface $createdBefore = null,
        public ?CarbonInterface $updatedAfter = null,
        public ?CarbonInterface $updatedBefore = null,
        public ?int $buyerId = null,
        public ?Country $countryCode = null,
        public ?OrderStatus $status = null,
        public ?Marketplace $marketplace = null,
        public ?SortTimestamp $sortBy = null,
        public ?SortDirection $sortDirection = null,
        public ?int $offset = null,
        public ?int $limit = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $dateFormat = 'd-m-Y H:i:s';

        $rules = [
            'created_after' => ['required_without:updated_after', "date_format:$dateFormat"],
            'created_before' => ["date_format:$dateFormat"],
            'updated_after' => ['required_without:created_after', "date_format:$dateFormat"],
            'updated_before' => ["date_format:$dateFormat"],
            'buyer_id' => ['integer'],
            'country_code' => [Rule::enum(Country::class)],
            'status' => [Rule::enum(OrderStatus::class)],
            'marketplace' => [Rule::enum(Marketplace::class)],
            'sort_by' => [Rule::enum(SortTimestamp::class)],
            'sort_direction' => [Rule::enum(SortDirection::class)],
            'offset' => ['integer', 'multiple_of:10'],
            'limit' => ['integer', 'multiple_of:10', 'between:1,100'],
        ];

        $attributes = array_fill_keys(array_keys($rules), null);

        foreach (Validator::validate($data, $rules) as $key => $value) {
            if ($key === 'country_code') {
                $value = Country::tryFrom($value);
            } elseif ($key === 'status') {
                $value = OrderStatus::tryFrom($value);
            } elseif ($key === 'marketplace') {
                $value = Marketplace::tryFrom($value);
            } elseif ($key === 'sort_by') {
                $value = SortTimestamp::tryFrom($value);
            } elseif ($key === 'sort_direction') {
                $value = SortDirection::tryFrom($value);
            } elseif (in_array($key, ['created_after', 'created_before', 'updated_after', 'updated_before'])) {
                $value = Date::createFromFormat($dateFormat, $value);
            } elseif (in_array($key, ['buyer_id', 'offset', 'limit'])) {
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
