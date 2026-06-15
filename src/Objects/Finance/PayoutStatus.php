<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Finance;

use Deplox\MiraviaSdk\Support\ApiValueParser;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Date;

/** @implements Arrayable<string, mixed> */
final readonly class PayoutStatus implements Arrayable
{
    public function __construct(
        public string $statementNumber,
        public bool $paid,
        public float $openingBalance,
        public float $closingBalance,
        public float $payout,
        public float $itemRevenue,
        public float $shipmentFee,
        public float $shipmentFeeCredit,
        public float $otherFeesTotal,
        public float $refunds,
        public float $guaranteeWithhold,
        public float $guaranteeRelease,
        public ?CarbonInterface $createdAt,
        public ?CarbonInterface $updatedAt,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        return new self(
            (string) ($data['statement_number'] ?? ''),
            ApiValueParser::bool($data['paid'] ?? false),
            ApiValueParser::amount($data['opening_balance'] ?? null),
            ApiValueParser::amount($data['closing_balance'] ?? null),
            ApiValueParser::amount($data['payout'] ?? null),
            ApiValueParser::amount($data['item_revenue'] ?? null),
            ApiValueParser::amount($data['shipment_fee'] ?? null),
            ApiValueParser::amount($data['shipment_fee_credit'] ?? null),
            ApiValueParser::amount($data['other_fees_total'] ?? null),
            ApiValueParser::amount($data['refunds'] ?? null),
            ApiValueParser::amount($data['guarantee_withhold'] ?? null),
            ApiValueParser::amount($data['guarantee_release'] ?? null),
            isset($data['created_at']) ? Date::parse($data['created_at']) : null,
            isset($data['updated_at']) ? Date::parse($data['updated_at']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'statement_number' => $this->statementNumber,
            'paid' => $this->paid,
            'opening_balance' => $this->openingBalance,
            'closing_balance' => $this->closingBalance,
            'payout' => $this->payout,
            'item_revenue' => $this->itemRevenue,
            'shipment_fee' => $this->shipmentFee,
            'shipment_fee_credit' => $this->shipmentFeeCredit,
            'other_fees_total' => $this->otherFeesTotal,
            'refunds' => $this->refunds,
            'guarantee_withhold' => $this->guaranteeWithhold,
            'guarantee_release' => $this->guaranteeRelease,
            'created_at' => $this->createdAt ? (string) $this->createdAt : null,
            'updated_at' => $this->updatedAt ? (string) $this->updatedAt : null,
        ];
    }
}
