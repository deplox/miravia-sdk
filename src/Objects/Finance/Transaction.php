<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Finance;

use Deplox\MiraviaSdk\Enums\TransactionType;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Date;

/** @implements Arrayable<string, mixed> */
final readonly class Transaction implements Arrayable
{
    public function __construct(
        public ?int $feeTypeId,
        public ?string $feeName,
        public ?string $transactionType,
        public ?string $details,
        public ?string $comment,
        public float $amount,
        public float $vatInAmount,
        public bool $paid,
        public ?string $sellerSku,
        public ?string $miraviaSku,
        public ?string $orderId,
        public ?string $orderItemId,
        public ?string $orderItemStatus,
        public ?string $reference,
        public ?string $shippingProvider,
        public ?string $shippingSpeed,
        public ?string $shipmentType,
        public ?string $statement,
        public ?string $statementNumber,
        public ?CarbonInterface $transactionDate,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        $feeTypeId = isset($data['fee_type']) ? (int) $data['fee_type'] : null;

        return new self(
            $feeTypeId,
            $data['fee_name'] ?? null,
            $data['transaction_type'] ?? null,
            $data['details'] ?? null,
            $data['comment'] ?? null,
            (float) ($data['amount'] ?? 0),
            (float) ($data['VAT_in_amount'] ?? 0),
            ($data['paid_status'] ?? null) === 'Paid',
            $data['seller_sku'] ?? null,
            $data['miravia_sku'] ?? null,
            isset($data['order_no']) ? (string) $data['order_no'] : null,
            isset($data['orderItem_no']) ? (string) $data['orderItem_no'] : null,
            $data['orderItem_status'] ?? null,
            isset($data['reference']) ? (string) $data['reference'] : null,
            $data['shipping_provider'] ?? null,
            $data['shipping_speed'] ?? null,
            $data['shipment_type'] ?? null,
            isset($data['statement']) ? (string) $data['statement'] : null,
            $data['statement_number'] ?? null,
            isset($data['transaction_date']) ? Date::parse($data['transaction_date']) : null,
        );
    }

    public function feeTypeEnum(): ?TransactionType
    {
        return $this->feeTypeId !== null ? TransactionType::tryFrom($this->feeTypeId) : null;
    }

    public function toArray(): array
    {
        return [
            'fee_type_id' => $this->feeTypeId,
            'fee_name' => $this->feeName,
            'transaction_type' => $this->transactionType,
            'details' => $this->details,
            'comment' => $this->comment,
            'amount' => $this->amount,
            'vat_in_amount' => $this->vatInAmount,
            'paid' => $this->paid,
            'seller_sku' => $this->sellerSku,
            'miravia_sku' => $this->miraviaSku,
            'order_id' => $this->orderId,
            'order_item_id' => $this->orderItemId,
            'order_item_status' => $this->orderItemStatus,
            'reference' => $this->reference,
            'shipping_provider' => $this->shippingProvider,
            'shipping_speed' => $this->shippingSpeed,
            'shipment_type' => $this->shipmentType,
            'statement' => $this->statement,
            'statement_number' => $this->statementNumber,
            'transaction_date' => $this->transactionDate ? (string) $this->transactionDate : null,
        ];
    }
}
