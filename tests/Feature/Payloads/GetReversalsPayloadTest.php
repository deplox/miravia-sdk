<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\Enums\Marketplace;
use Deplox\MiraviaSdk\Payloads\ReturnAndRefund\GetReversalsPayload;
use Illuminate\Validation\ValidationException;

it('has sensible defaults', function () {
    $payload = new GetReversalsPayload;

    expect($payload->pageNo)->toBe(1)
        ->and($payload->pageSize)->toBe(10)
        ->and($payload->marketplace)->toBeNull()
        ->and($payload->disputeInProgress)->toBeNull();
});

it('creates payload from empty array using defaults', function () {
    $payload = GetReversalsPayload::fromArray([]);

    expect($payload->pageNo)->toBe(1)
        ->and($payload->pageSize)->toBe(10);
});

it('creates payload from array with pagination', function () {
    $payload = GetReversalsPayload::fromArray([
        'page_no' => 2,
        'page_size' => 50,
        'marketplace' => 'miravia',
    ]);

    expect($payload->pageNo)->toBe(2)
        ->and($payload->pageSize)->toBe(50)
        ->and($payload->marketplace)->toBe(Marketplace::Miravia);
});

it('creates payload with date range', function () {
    $payload = GetReversalsPayload::fromArray([
        'reverse_order_line_start_time' => '01-01-2024 00:00:00',
        'reverse_order_line_end_time' => '31-01-2024 23:59:59',
    ]);

    expect($payload->reverseOrderLineStartTime)->not->toBeNull()
        ->and($payload->reverseOrderLineStartTime->format('Y-m-d'))->toBe('2024-01-01')
        ->and($payload->reverseOrderLineEndTime->format('Y-m-d'))->toBe('2024-01-31');
});

it('fails validation with page_size over 200', function () {
    GetReversalsPayload::fromArray(['page_size' => 201]);
})->throws(ValidationException::class);

it('fails validation with page_no less than 1', function () {
    GetReversalsPayload::fromArray(['page_no' => 0]);
})->throws(ValidationException::class);
