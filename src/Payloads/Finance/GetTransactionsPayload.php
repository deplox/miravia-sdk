<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Payloads\Finance;

use Deplox\MiraviaSdk\Enums\TransactionType;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

final class GetTransactionsPayload
{
    public function __construct(
        public ?CarbonInterface $startTime,
        public ?CarbonInterface $endTime,
        public ?TransactionType $transactionType = null,
        public ?int $tradeOrderId = null,
        public ?int $tradeOrderLineId = null,
        public ?int $offset = null,
        public ?int $limit = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $dateFormat = 'd-m-Y';

        $rules = [
            'start_time' => ['required', "date_format:$dateFormat"],
            'end_time' => ['required', "date_format:$dateFormat"],
            'transaction_type' => [Rule::enum(TransactionType::class)],
            'trade_order_id' => ['integer'],
            'trade_order_line_id' => ['integer'],
            'offset' => ['integer', 'multiple_of:10'],
            'limit' => ['integer', 'multiple_of:10', 'between:1,500'],
        ];

        $attributes = array_fill_keys(array_keys($rules), null);

        foreach (Validator::validate($data, $rules) as $key => $value) {
            if ($key === 'transaction_type') {
                $value = TransactionType::tryFrom((int) $value);
            } elseif (in_array($key, ['start_time', 'end_time'])) {
                $value = Date::createFromFormat($dateFormat, $value);
            } elseif (in_array($key, ['trade_order_id', 'trade_order_line_id', 'offset', 'limit'])) {
                $value = (int) $value;
            }

            $attributes[$key] = $value;
        }

        return new self(
            startTime: $attributes['start_time'],
            endTime: $attributes['end_time'],
            transactionType: $attributes['transaction_type'],
            tradeOrderId: $attributes['trade_order_id'],
            tradeOrderLineId: $attributes['trade_order_line_id'],
            offset: $attributes['offset'],
            limit: $attributes['limit'],
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
