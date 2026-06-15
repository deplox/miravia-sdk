<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\ReturnAndRefund;

use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\OfcStatus;
use Deplox\MiraviaSdk\Enums\ReversalStatus;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Date;

final readonly class ReversalLine implements Arrayable
{
    public function __construct(
        public int $id,
        public int $reversalId,
        public int $tradeOrderLineId,
        public string $reverseStatus,
        public ?string $ofcStatus,
        public ?string $marketplace,
        public ?string $platformSkuId,
        public ?string $sellerSkuId,
        public ?string $buyerId,
        public ?string $reasonText,
        public float $refundAmount,
        public string $refundCurrency,
        public int $refundItemCounts,
        public ?string $refundPaymentMethod,
        public ?string $trackingNumber,
        public ?string $goodsStatus,
        public ?string $whqcDecision,
        public ?array $actions,
        public ?array $tradeOrderLineIdList,
        public ?int $platformTradeOrderLineId,
        public ?string $eanCode,
        public bool $isDispute,
        public bool $isFastRefund,
        public bool $isReturnAble,
        public bool $isInstantRefund,
        public bool $isNotReceived,
        public ?CarbonInterface $tradeOrderCreatedAt,
        public ?CarbonInterface $createdAt,
        public ?CarbonInterface $updatedAt,
    ) {}

    public static function fromApiResponse(array $data, int $reversalId): self
    {
        $data = array_filter($data, fn (mixed $value): bool => isset($value) && $value !== '');

        return new self(
            (int) ($data['reverse_order_line_id'] ?? 0),
            $reversalId,
            (int) ($data['trade_order_line_id'] ?? 0),
            ReversalStatus::fromApiValue($data['reverse_status'] ?? ''),
            isset($data['ofc_status']) ? OfcStatus::fromApiValue($data['ofc_status']) : null,
            isset($data['marketplace']) ? Marketplace::fromApiValue((string) $data['marketplace']) : null,
            $data['platform_sku_id'] ?? null,
            $data['seller_sku_id'] ?? null,
            isset($data['buyer']['user_id']) ? (string) $data['buyer']['user_id'] : null,
            $data['reason_text'] ?? null,
            ((float) ($data['refund_amount'] ?? 0)) / 100,
            (string) ($data['refund_currency'] ?? 'EUR'),
            (int) ($data['refund_Item_counts'] ?? $data['refund_item_counts'] ?? 0),
            $data['refund_payment_method'] ?? null,
            $data['tracking_number'] ?? null,
            $data['goods_status'] ?? null,
            $data['whqc_decision'] ?? null,
            ! empty($data['actions']) ? $data['actions'] : null,
            $data['trade_order_line_id_list'] ?? null,
            isset($data['marketplace_trade_order_line_id']) ? (int) $data['marketplace_trade_order_line_id'] : null,
            $data['spu_eancode'] ?? null,
            (bool) ($data['is_dispute'] ?? false),
            (bool) ($data['is_fast_refund'] ?? false),
            (bool) ($data['return_able'] ?? false),
            (bool) ($data['is_instant_refund'] ?? false),
            (bool) ($data['is_not_received'] ?? false),
            isset($data['trade_order_gmt_create']) ? Date::createFromTimestamp((int) $data['trade_order_gmt_create']) : null,
            isset($data['return_order_line_gmt_create']) ? Date::createFromTimestamp((int) $data['return_order_line_gmt_create']) : null,
            isset($data['return_order_line_gmt_modified']) ? Date::createFromTimestamp((int) $data['return_order_line_gmt_modified']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'reversal_id' => $this->reversalId,
            'trade_order_line_id' => $this->tradeOrderLineId,
            'reverse_status' => $this->reverseStatus,
            'ofc_status' => $this->ofcStatus,
            'marketplace' => $this->marketplace,
            'platform_sku_id' => $this->platformSkuId,
            'seller_sku_id' => $this->sellerSkuId,
            'buyer_id' => $this->buyerId,
            'reason_text' => $this->reasonText,
            'refund_amount' => $this->refundAmount,
            'refund_currency' => $this->refundCurrency,
            'refund_item_counts' => $this->refundItemCounts,
            'refund_payment_method' => $this->refundPaymentMethod,
            'tracking_number' => $this->trackingNumber,
            'goods_status' => $this->goodsStatus,
            'whqc_decision' => $this->whqcDecision,
            'actions' => $this->actions,
            'trade_order_line_id_list' => $this->tradeOrderLineIdList,
            'platform_trade_order_line_id' => $this->platformTradeOrderLineId,
            'ean_code' => $this->eanCode,
            'is_dispute' => $this->isDispute,
            'is_fast_refund' => $this->isFastRefund,
            'is_return_able' => $this->isReturnAble,
            'is_instant_refund' => $this->isInstantRefund,
            'is_not_received' => $this->isNotReceived,
            'trade_order_created_at' => $this->tradeOrderCreatedAt ? (string) $this->tradeOrderCreatedAt : null,
            'created_at' => $this->createdAt ? (string) $this->createdAt : null,
            'updated_at' => $this->updatedAt ? (string) $this->updatedAt : null,
        ];
    }
}
