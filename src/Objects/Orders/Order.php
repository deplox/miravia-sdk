<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Orders;

use Deplox\MiraviaSdk\Enums\Country;
use Deplox\MiraviaSdk\Enums\Currency;
use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\OrderStatus;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

final readonly class Order implements Arrayable
{
    /**
     * @param  Collection<string>  $statuses
     */
    public function __construct(
        public int $id,
        public ?int $orderNumber,
        public string $countryCode,
        public string $currencyCode,
        public string $marketplaceCode,
        public string $warehouseCode,
        public ?string $customerName,
        public ?string $paymentMethod,
        public Collection $statuses,
        public int $quantity,
        public float $total,
        public float $shippingFee,
        public float $shippingFeeOriginal,
        public float $shippingFeeDiscount,
        public float $voucher,
        public float $voucherSeller,
        public ?string $sellerRemarkText,
        public ?string $buyerRemarkText,
        public bool $needCancelConfirm,
        public bool $cancelSellerAgreed,
        public bool $isCancelPending,
        public ?CarbonInterface $cancelTriggerDate,
        public ?Address $addressBilling,
        public ?Address $addressShipping,
        public CarbonInterface $createdAt,
        public CarbonInterface $updatedAt,
    ) {}

    public static function fromApiResponse(array $data): self
    {
        $data = array_filter($data, fn (mixed $value): bool => isset($value) && $value !== '');

        return new self(
            (int) $data['order_id'],
            isset($data['order_number']) ? (int) $data['order_number'] : null,
            Country::fromApiValue($data['country'] ?? ''),
            Currency::EUR->value,
            Marketplace::fromApiValue((string) $data['marketplace']),
            (string) $data['warehouse_code'],
            $data['customer_first_name'] ?? null,
            $data['payment_method'] ?? null,
            (new Collection($data['statuses']))->map(fn (string $status): string => OrderStatus::fromApiValue($status)),
            (int) ($data['items_count'] ?? 0),
            (float) ($data['price'] ?? 0),
            (float) ($data['shipping_fee'] ?? 0),
            (float) ($data['shipping_fee_original'] ?? 0),
            (float) ($data['shipping_fee_discount_seller'] ?? 0),
            (float) ($data['voucher'] ?? 0),
            (float) ($data['voucher_seller'] ?? 0),
            $data['seller_remark_text'] ?? null,
            $data['buyer_remark_text'] ?? null,
            (bool) ($data['need_cancel_confirm'] ?? false),
            (bool) ($data['cancel_seller_agreed'] ?? false),
            (bool) ($data['is_cancel_pending'] ?? false),
            isset($data['cancel_trigger_date']) ? Date::parse($data['cancel_trigger_date']) : null,
            isset($data['address_billing']) ? Address::fromApiResponse($data['address_billing']) : null,
            isset($data['address_shipping']) ? Address::fromApiResponse($data['address_shipping']) : null,
            Date::parse($data['created_at']),
            Date::parse($data['updated_at']),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->orderNumber,
            'country_code' => $this->countryCode,
            'currency_code' => $this->currencyCode,
            'marketplace_code' => $this->marketplaceCode,
            'warehouse_code' => $this->warehouseCode,
            'customer_name' => $this->customerName,
            'statuses' => $this->statuses->toArray(),
            'payment_method' => $this->paymentMethod,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'shipping_fee' => $this->shippingFee,
            'shipping_fee_original' => $this->shippingFeeOriginal,
            'shipping_fee_discount' => $this->shippingFeeDiscount,
            'voucher' => $this->voucher,
            'voucher_seller' => $this->voucherSeller,
            'seller_remark_text' => $this->sellerRemarkText,
            'buyer_remark_text' => $this->buyerRemarkText,
            'need_cancel_confirm' => $this->needCancelConfirm,
            'cancel_seller_agreed' => $this->cancelSellerAgreed,
            'is_cancel_pending' => $this->isCancelPending,
            'cancel_trigger_date' => $this->cancelTriggerDate ? (string) $this->cancelTriggerDate : null,
            'address_billing' => $this->addressBilling?->toArray(),
            'address_shipping' => $this->addressShipping?->toArray(),
            'created_at' => (string) $this->createdAt,
            'updated_at' => (string) $this->updatedAt,
        ];
    }
}
