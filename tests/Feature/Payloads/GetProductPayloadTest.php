<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Enums\ProductStatus;
use Deplox\MiraviaSdk\Payloads\ProductV2\GetProductPayload;
use Illuminate\Validation\ValidationException;

it('creates empty payload with all nulls', function () {
    $payload = new GetProductPayload;

    expect($payload->ids)->toBeNull()
        ->and($payload->skus)->toBeNull()
        ->and($payload->marketplace)->toBeNull()
        ->and($payload->status)->toBeNull()
        ->and($payload->page)->toBeNull()
        ->and($payload->pageSize)->toBeNull();
});

it('creates payload from array with ids', function () {
    $payload = GetProductPayload::fromArray([
        'ids' => [1, 2, 3],
        'page' => 1,
        'page_size' => 50,
    ]);

    expect($payload->ids)->toBe([1, 2, 3])
        ->and($payload->page)->toBe(1)
        ->and($payload->pageSize)->toBe(50);
});

it('creates payload from array with marketplace and status', function () {
    $payload = GetProductPayload::fromArray([
        'marketplace' => 'miravia',
        'status' => 'active',
    ]);

    expect($payload->marketplace)->toBe(Marketplace::Miravia)
        ->and($payload->status)->toBe(ProductStatus::Active);
});

it('fails validation with page_size over 50', function () {
    GetProductPayload::fromArray(['page_size' => 100]);
})->throws(ValidationException::class);

it('fails validation with page less than 1', function () {
    GetProductPayload::fromArray(['page' => 0]);
})->throws(ValidationException::class);

it('normalizes ids to list (re-indexes array)', function () {
    $payload = new GetProductPayload(ids: [10 => 1, 20 => 2]);
    expect($payload->ids)->toBe([1, 2]);
});
