<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\Enums\Country;
use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\OrderStatus;
use Deplox\MiraviaSdk\Payloads\Orders\GetOrdersPayload;
use Illuminate\Validation\ValidationException;

it('creates payload from array with created_after', function () {
    $payload = GetOrdersPayload::fromArray([
        'created_after' => '15-01-2024 00:00:00',
    ]);

    expect($payload->createdAfter)->not->toBeNull()
        ->and($payload->createdAfter->format('Y-m-d'))->toBe('2024-01-15')
        ->and($payload->status)->toBeNull()
        ->and($payload->marketplace)->toBeNull();
});

it('creates payload from array with updated_after', function () {
    $payload = GetOrdersPayload::fromArray([
        'updated_after' => '15-01-2024 00:00:00',
    ]);

    expect($payload->updatedAfter)->not->toBeNull()
        ->and($payload->createdAfter)->toBeNull();
});

it('creates payload with all optional fields', function () {
    $payload = GetOrdersPayload::fromArray([
        'created_after' => '15-01-2024 00:00:00',
        'created_before' => '20-01-2024 23:59:59',
        'country_code' => 'es',
        'status' => 'pending',
        'marketplace' => 'miravia',
        'offset' => 10,
        'limit' => 50,
    ]);

    expect($payload->countryCode)->toBe(Country::Spain)
        ->and($payload->status)->toBe(OrderStatus::Pending)
        ->and($payload->marketplace)->toBe(Marketplace::Miravia)
        ->and($payload->offset)->toBe(10)
        ->and($payload->limit)->toBe(50);
});

it('fails validation when neither created_after nor updated_after provided', function () {
    GetOrdersPayload::fromArray(['status' => 'pending']);
})->throws(ValidationException::class);

it('fails validation with invalid status enum', function () {
    GetOrdersPayload::fromArray([
        'created_after' => '15-01-2024 00:00:00',
        'status' => 'not_a_real_status',
    ]);
})->throws(ValidationException::class);

it('fails validation with offset not multiple of 10', function () {
    GetOrdersPayload::fromArray([
        'created_after' => '15-01-2024 00:00:00',
        'offset' => 7,
    ]);
})->throws(ValidationException::class);

it('fails validation with limit exceeding 100', function () {
    GetOrdersPayload::fromArray([
        'created_after' => '15-01-2024 00:00:00',
        'limit' => 200,
    ]);
})->throws(ValidationException::class);

it('exposes toArray with all keys', function () {
    $payload = GetOrdersPayload::fromArray([
        'created_after' => '15-01-2024 00:00:00',
    ]);

    $arr = $payload->toArray();
    expect($arr)->toHaveKeys(['createdAfter', 'createdBefore', 'status', 'marketplace', 'offset', 'limit']);
});
