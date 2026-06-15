<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Payloads\ReturnAndRefund;

use Deplox\MiraviaSdk\Enums\Marketplace;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class GetReversalsPayload
{
    public function __construct(
        public int $pageNo = 1,
        public int $pageSize = 10,
        public ?string $ofcStatusList = null,
        public ?string $reverseStatusList = null,
        public ?int $reverseOrderId = null,
        public ?int $tradeOrderId = null,
        public ?CarbonInterface $reverseOrderLineStartTime = null,
        public ?CarbonInterface $reverseOrderLineEndTime = null,
        public ?CarbonInterface $tradeOrderStartTime = null,
        public ?CarbonInterface $tradeOrderEndTime = null,
        public ?bool $disputeInProgress = null,
        public ?string $reverseTrackingNumber = null,
        public ?Marketplace $marketplace = null,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        $dateFormat = 'd-m-Y H:i:s';

        $rules = [
            'page_no' => ['integer', 'min:1'],
            'page_size' => ['integer', 'min:1', 'max:200'],
            'ofc_status_list' => ['string'],
            'reverse_status_list' => ['string'],
            'reverse_order_id' => ['integer'],
            'trade_order_id' => ['integer'],
            'reverse_order_line_start_time' => ["date_format:$dateFormat"],
            'reverse_order_line_end_time' => ["date_format:$dateFormat"],
            'trade_order_start_time' => ["date_format:$dateFormat"],
            'trade_order_end_time' => ["date_format:$dateFormat"],
            'dispute_in_progress' => ['boolean'],
            'reverse_tracking_number' => ['string'],
            'marketplace' => [Rule::enum(Marketplace::class)],
        ];

        $attributes = array_fill_keys(array_keys($rules), null);

        foreach (Validator::validate($data, $rules) as $key => $value) {
            if ($key === 'marketplace') {
                $value = Marketplace::tryFrom($value);
            } elseif (in_array($key, ['reverse_order_line_start_time', 'reverse_order_line_end_time', 'trade_order_start_time', 'trade_order_end_time'])) {
                $value = Date::createFromFormat($dateFormat, $value);
            } elseif (in_array($key, ['page_no', 'page_size', 'reverse_order_id', 'trade_order_id'])) {
                $value = (int) $value;
            } elseif ($key === 'dispute_in_progress') {
                $value = (bool) $value;
            }

            $attributes[$key] = $value;
        }

        return new self(
            pageNo: $attributes['page_no'] ?? 1,
            pageSize: $attributes['page_size'] ?? 10,
            ofcStatusList: $attributes['ofc_status_list'],
            reverseStatusList: $attributes['reverse_status_list'],
            reverseOrderId: $attributes['reverse_order_id'],
            tradeOrderId: $attributes['trade_order_id'],
            reverseOrderLineStartTime: $attributes['reverse_order_line_start_time'],
            reverseOrderLineEndTime: $attributes['reverse_order_line_end_time'],
            tradeOrderStartTime: $attributes['trade_order_start_time'],
            tradeOrderEndTime: $attributes['trade_order_end_time'],
            disputeInProgress: $attributes['dispute_in_progress'],
            reverseTrackingNumber: $attributes['reverse_tracking_number'],
            marketplace: $attributes['marketplace'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
