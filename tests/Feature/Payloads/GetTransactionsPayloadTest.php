<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\Payloads\Finance\GetTransactionsPayload;
use Illuminate\Validation\ValidationException;

it('creates transactions payload with required dates', function () {
    $payload = GetTransactionsPayload::fromArray([
        'start_time' => '01-01-2024',
        'end_time' => '31-01-2024',
    ]);

    expect($payload->startTime)->not->toBeNull()
        ->and($payload->startTime->format('Y-m-d'))->toBe('2024-01-01')
        ->and($payload->endTime->format('Y-m-d'))->toBe('2024-01-31')
        ->and($payload->transactionType)->toBeNull()
        ->and($payload->offset)->toBeNull()
        ->and($payload->limit)->toBeNull();
});

it('creates payload with optional filters', function () {
    $payload = GetTransactionsPayload::fromArray([
        'start_time' => '01-01-2024',
        'end_time' => '31-01-2024',
        'trade_order_id' => '12345',
        'offset' => 10,
        'limit' => 50,
    ]);

    expect($payload->tradeOrderId)->toBe(12345)
        ->and($payload->offset)->toBe(10)
        ->and($payload->limit)->toBe(50);
});

it('fails validation without start_time', function () {
    GetTransactionsPayload::fromArray(['end_time' => '31-01-2024']);
})->throws(ValidationException::class);

it('fails validation without end_time', function () {
    GetTransactionsPayload::fromArray(['start_time' => '01-01-2024']);
})->throws(ValidationException::class);

it('fails validation with wrong date format', function () {
    GetTransactionsPayload::fromArray([
        'start_time' => '2024-01-01',
        'end_time' => '2024-01-31',
    ]);
})->throws(ValidationException::class);

it('fails validation with limit over 500', function () {
    GetTransactionsPayload::fromArray([
        'start_time' => '01-01-2024',
        'end_time' => '31-01-2024',
        'limit' => 600,
    ]);
})->throws(ValidationException::class);
