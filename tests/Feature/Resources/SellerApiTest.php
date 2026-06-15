<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\MiraviaConnector;
use Deplox\MiraviaSdk\Objects\Seller\Seller;
use Deplox\MiraviaSdk\Objects\Seller\WarehouseCollection;
use Deplox\MiraviaSdk\Resources\SellerApi;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function sellerConnector(): MiraviaConnector
{
    return new MiraviaConnector('key', 'secret', 'sha256', 'token');
}

it('get() maps seller response to DTO', function () {
    $connector = sellerConnector();
    $mockClient = new MockClient([
        MockResponse::make([
            'code' => '0',
            'data' => [
                'seller_id' => '42',
                'name' => 'My Shop',
                'status' => 'active',
                'verified' => 'true',
                'cb' => 'false',
                'is_m2a_seller' => 'false',
                'sell_countries' => ['ES', 'IT'],
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $seller = (new SellerApi($connector))->get()->dto();

    expect($seller)->toBeInstanceOf(Seller::class)
        ->and($seller->id)->toBe(42)
        ->and($seller->name)->toBe('My Shop')
        ->and($seller->verified)->toBeTrue()
        ->and($seller->crossBorder)->toBeFalse()
        ->and($seller->sellCountries)->toBe(['ES', 'IT']);
});

it('get() handles boolean strings from API correctly', function () {
    $connector = sellerConnector();
    $mockClient = new MockClient([
        MockResponse::make([
            'code' => '0',
            'data' => [
                'seller_id' => '1',
                'name' => 'Shop',
                'status' => 'active',
                'verified' => 'false',
                'cb' => 'true',
                'is_m2a_seller' => 'true',
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $seller = (new SellerApi($connector))->get()->dto();

    expect($seller->verified)->toBeFalse()
        ->and($seller->crossBorder)->toBeTrue()
        ->and($seller->isM2aSeller)->toBeTrue();
});

it('warehouses() returns a WarehouseCollection', function () {
    $connector = sellerConnector();
    $mockClient = new MockClient([
        MockResponse::make([
            'code' => '0',
            'result' => [
                'module' => [
                    ['warehouse_id' => '1', 'name' => 'Main WH', 'is_default' => 'true', 'status' => 'active'],
                ],
            ],
        ]),
    ]);
    $connector->withMockClient($mockClient);

    $warehouses = (new SellerApi($connector))->warehouses()->dto();

    expect($warehouses)->toBeInstanceOf(WarehouseCollection::class)
        ->and($warehouses->items)->toHaveCount(1);
});
