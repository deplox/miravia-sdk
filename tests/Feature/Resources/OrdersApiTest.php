<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\MiraviaConnector;
use Deplox\MiraviaSdk\Objects\Orders\Order;
use Deplox\MiraviaSdk\Objects\Orders\OrderCollection;
use Deplox\MiraviaSdk\Objects\Orders\OrderItem;
use Deplox\MiraviaSdk\Payloads\Orders\GetOrdersPayload;
use Deplox\MiraviaSdk\Resources\OrdersApi;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function ordersConnector(): MiraviaConnector
{
    return new MiraviaConnector('key', 'secret', 'sha256', 'token');
}

function orderData(array $overrides = []): array
{
    return array_merge([
        'order_id' => '12345',
        'country' => 'ES',
        'marketplace' => 'miravia',
        'warehouse_code' => 'WH01',
        'statuses' => ['pending'],
        'items_count' => 2,
        'price' => '49,99',
        'shipping_fee' => '2,99',
        'shipping_fee_original' => '2,99',
        'shipping_fee_discount_seller' => '0,00',
        'voucher' => '0,00',
        'voucher_seller' => '0,00',
        'need_cancel_confirm' => 'false',
        'cancel_seller_agreed' => 'false',
        'is_cancel_pending' => 'false',
        'created_at' => '2024-01-15 10:00:00',
        'updated_at' => '2024-01-15 11:00:00',
    ], $overrides);
}

function orderItemData(array $overrides = []): array
{
    return array_merge([
        'order_item_id' => '1001',
        'order_id' => '12345',
        'marketplace_order_line_id' => '9001',
        'country' => 'ES',
        'currency' => 'EUR',
        'marketplace' => 'miravia',
        'warehouse_code' => 'WH01',
        'buyer_id' => '55555',
        'product_id' => '111',
        'sku_id' => '222',
        'shop_sku' => 'SHOP-SKU-001',
        'sku' => 'SKU-001',
        'name' => 'Test Product',
        'shipping_type' => 'dropshipping',
        'item_price' => '19,99',
        'paid_price' => '19,99',
        'tax_amount' => '0,00',
        'shipping_amount' => '2,99',
        'shipping_fee_original' => '2,99',
        'shipping_fee_discount_seller' => '0,00',
        'shipping_service_cost' => '0,00',
        'voucher_amount' => '0,00',
        'voucher_seller' => '0,00',
        'voucher_seller_lpi' => '0,00',
        'voucher_platform_lpi' => '0,00',
        'cancel_return_initiator' => 'null-null',
        'status' => 'pending',
        'created_at' => '2024-01-15 10:00:00',
        'updated_at' => '2024-01-15 11:00:00',
    ], $overrides);
}

it('list() returns an OrderCollection DTO', function () {
    $connector = ordersConnector();
    $mockClient = new MockClient([
        MockResponse::make([
            'code' => '0',
            'data' => ['countTotal' => 1, 'orders' => [orderData()]],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $dto = (new OrdersApi($connector))->list(new GetOrdersPayload(createdAfter: now()->subDay()))->dto();

    expect($dto)->toBeInstanceOf(OrderCollection::class)
        ->and($dto->total)->toBe(1)
        ->and($dto->items)->toHaveCount(1)
        ->and($dto->items->first())->toBeInstanceOf(Order::class);
});

it('list() maps monetary amounts with European decimal comma', function () {
    $connector = ordersConnector();
    $mockClient = new MockClient([
        MockResponse::make([
            'code' => '0',
            'data' => ['countTotal' => 1, 'orders' => [orderData()]],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $order = (new OrdersApi($connector))->list(new GetOrdersPayload(createdAfter: now()->subDay()))
        ->dto()->items->first();

    expect($order->id)->toBe(12345)
        ->and($order->total)->toBe(49.99)
        ->and($order->shippingFee)->toBe(2.99)
        ->and($order->quantity)->toBe(2)
        ->and($order->countryCode)->toBe('es')
        ->and($order->marketplaceCode)->toBe('miravia');
});

it('get() returns a single Order DTO', function () {
    $connector = ordersConnector();
    $mockClient = new MockClient([
        MockResponse::make([
            'code' => '0',
            'data' => orderData(['order_id' => '99999']),
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $order = (new OrdersApi($connector))->get(99999)->dto();

    expect($order)->toBeInstanceOf(Order::class)
        ->and($order->id)->toBe(99999);
});

it('getItems() returns a collection of OrderItem', function () {
    $connector = ordersConnector();
    $mockClient = new MockClient([
        MockResponse::make(['code' => '0', 'data' => [orderItemData()]]),
    ]);
    $connector->withMockClient($mockClient);

    $items = (new OrdersApi($connector))->getItems(12345)->dto();

    expect($items)->toHaveCount(1)
        ->and($items->first())->toBeInstanceOf(OrderItem::class);
});

it('getItems() maps cancel_return_initiator null-null to null', function () {
    $connector = ordersConnector();
    $mockClient = new MockClient([
        MockResponse::make(['code' => '0', 'data' => [orderItemData(['cancel_return_initiator' => 'null-null'])]]),
    ]);
    $connector->withMockClient($mockClient);

    $item = (new OrdersApi($connector))->getItems(12345)->dto()->first();

    expect($item->cancelReturnInitiator)->toBeNull();
});
