<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\Orders;

use Deplox\MiraviaSdk\Enums\Country;
use Deplox\MiraviaSdk\Enums\Currency;
use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\OrderStatus;
use Deplox\MiraviaSdk\Support\ApiValueParser;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Date;

/** @implements Arrayable<string, mixed> */
final readonly class OrderItem implements Arrayable
{
    public function __construct(
        public int $id,
        public int $orderId,
        public int $orderLineId, // same as 'id' if marketplace is miravia, different if aliexpress
        public string $countryCode,
        public string $currencyCode,
        public string $marketplaceCode,
        public string $warehouseCode,
        public string $buyerId,
        public string $productId,
        public string $skuId,
        public string $shopSku,
        public string $sellerSku,
        public string $shippingType,
        public string $name,
        public string $productUrl,
        public ?string $productMainImage,
        public ?string $variation,
        public ?string $shopId,
        public bool $isFbm,
        public int $quantity,
        public float $itemPrice,
        public float $paidPrice,
        public float $tax,
        public float $shippingFee,
        public float $shippingFeeOriginal,
        public float $shippingFeeDiscount,
        public float $shippingServiceCost,
        public float $voucher,
        public float $voucherSeller,
        public float $voucherSellerLpi,
        public float $voucherPlatformLpi,
        public ?string $voucherCode,
        public ?string $trackingCode,
        public ?string $shipmentProvider,
        public ?string $shippingProviderType,
        public ?CarbonInterface $slaTimeStamp,
        public ?string $packageId,
        public ?string $orderFlag,
        public ?string $orderType,
        public bool $deliveryOptionSof,
        public bool $isReroute,
        public bool $returnAble,
        public ?string $cancelReturnInitiator,
        public ?string $sellerRemarkText,
        public ?string $buyerRemarkText,
        public string $status,
        public ?string $reversalReason,
        public CarbonInterface $createdAt,
        public CarbonInterface $updatedAt,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        $data = array_filter($data, fn (mixed $value): bool => isset($value) && $value !== '');

        return new self(
            (int) $data['order_item_id'],
            (int) $data['order_id'],
            (int) $data['marketplace_order_line_id'],
            Country::fromApiValue($data['country'] ?? ''),
            Currency::fromApiValue($data['currency'] ?? ''),
            Marketplace::fromApiValue((string) $data['marketplace']),
            (string) $data['warehouse_code'],
            (string) $data['buyer_id'],
            (string) $data['product_id'],
            (string) $data['sku_id'],
            (string) $data['shop_sku'],
            (string) $data['sku'],
            strtolower($data['shipping_type'] ?? ''),
            $data['name'] ?? '',
            $data['product_detail_url'] ?? '',
            $data['product_main_image'] ?? null,
            $data['variation'] ?? null,
            $data['shop_id'] ?? null,
            (bool) ($data['is_fbm'] ?? false),
            (int) ($data['quantity'] ?? 0),
            ApiValueParser::amount($data['item_price'] ?? null),
            ApiValueParser::amount($data['paid_price'] ?? null),
            ApiValueParser::amount($data['tax_amount'] ?? null),
            ApiValueParser::amount($data['shipping_amount'] ?? null),
            ApiValueParser::amount($data['shipping_fee_original'] ?? null),
            ApiValueParser::amount($data['shipping_fee_discount_seller'] ?? null),
            ApiValueParser::amount($data['shipping_service_cost'] ?? null),
            ApiValueParser::amount($data['voucher_amount'] ?? null),
            ApiValueParser::amount($data['voucher_seller'] ?? null),
            ApiValueParser::amount($data['voucher_seller_lpi'] ?? null),
            ApiValueParser::amount($data['voucher_platform_lpi'] ?? null),
            $data['voucher_code'] ?? null,
            $data['tracking_code'] ?? null,
            $data['shipment_provider'] ?? null,
            $data['shipping_provider_type'] ?? null,
            isset($data['sla_time_stamp']) ? Date::parse($data['sla_time_stamp']) : null,
            $data['package_id'] ?? null,
            $data['order_flag'] ?? null,
            $data['order_type'] ?? null,
            (bool) ($data['delivery_option_sof'] ?? false),
            (bool) ($data['is_reroute'] ?? false),
            (bool) ($data['return_able'] ?? false),
            ApiValueParser::cancelReturnInitiator($data['cancel_return_initiator'] ?? null),
            $data['seller_remark_text'] ?? null,
            $data['buyer_remark_text'] ?? null,
            OrderStatus::fromApiValue($data['status'] ?? ''),
            $data['reason'] ?? null,
            Date::parse($data['created_at']),
            Date::parse($data['updated_at']),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->orderId,
            'order_line_id' => $this->orderLineId,
            'country_code' => $this->countryCode,
            'currency_code' => $this->currencyCode,
            'marketplace_code' => $this->marketplaceCode,
            'warehouse_code' => $this->warehouseCode,
            'buyer_id' => $this->buyerId,
            'product_id' => $this->productId,
            'sku_id' => $this->skuId,
            'shop_sku' => $this->shopSku,
            'seller_sku' => $this->sellerSku,
            'shipping_type' => $this->shippingType,
            'name' => $this->name,
            'product_url' => $this->productUrl,
            'product_main_image' => $this->productMainImage,
            'variation' => $this->variation,
            'shop_id' => $this->shopId,
            'is_fbm' => $this->isFbm,
            'quantity' => $this->quantity,
            'item_price' => $this->itemPrice,
            'paid_price' => $this->paidPrice,
            'tax' => $this->tax,
            'shipping_fee' => $this->shippingFee,
            'shipping_fee_original' => $this->shippingFeeOriginal,
            'shipping_fee_discount' => $this->shippingFeeDiscount,
            'shipping_service_cost' => $this->shippingServiceCost,
            'voucher' => $this->voucher,
            'voucher_seller' => $this->voucherSeller,
            'voucher_seller_lpi' => $this->voucherSellerLpi,
            'voucher_platform_lpi' => $this->voucherPlatformLpi,
            'voucher_code' => $this->voucherCode,
            'tracking_code' => $this->trackingCode,
            'shipment_provider' => $this->shipmentProvider,
            'shipping_provider_type' => $this->shippingProviderType,
            'sla_time_stamp' => $this->slaTimeStamp ? (string) $this->slaTimeStamp : null,
            'package_id' => $this->packageId,
            'order_flag' => $this->orderFlag,
            'order_type' => $this->orderType,
            'delivery_option_sof' => $this->deliveryOptionSof,
            'is_reroute' => $this->isReroute,
            'return_able' => $this->returnAble,
            'cancel_return_initiator' => $this->cancelReturnInitiator,
            'seller_remark_text' => $this->sellerRemarkText,
            'buyer_remark_text' => $this->buyerRemarkText,
            'status' => $this->status,
            'reversal_reason' => $this->reversalReason,
            'created_at' => (string) $this->createdAt,
            'updated_at' => (string) $this->updatedAt,
        ];
    }
}
