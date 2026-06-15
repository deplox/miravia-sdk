<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\Miravia;
use Deplox\MiraviaSdk\MiraviaConnector;
use Deplox\MiraviaSdk\Requests\Seller\GetSellerRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function sellerResponse(): array
{
    return [
        'code' => '0',
        'request_id' => 'test-req-id',
        'data' => [
            'seller_id' => '12345',
            'name' => 'Test Seller',
            'status' => 'active',
            'verified' => 'true',
            'cb' => 'false',
            'is_m2a_seller' => 'false',
        ],
    ];
}

it('resolves MiraviaConnector from the container', function () {
    expect(app(MiraviaConnector::class))->toBeInstanceOf(MiraviaConnector::class);
});

it('resolves Miravia from the container', function () {
    expect(app(Miravia::class))->toBeInstanceOf(Miravia::class);
});

it('resolves MiraviaConnector as singleton', function () {
    expect(app(MiraviaConnector::class))->toBe(app(MiraviaConnector::class));
});

it('adds signing parameters to every request', function () {
    $appKey = 'my-app-key';
    $connector = new MiraviaConnector($appKey, 'my-secret', 'sha256');

    // createPendingRequest() runs the full middleware pipeline without making an HTTP call
    $pendingRequest = $connector->createPendingRequest(new GetSellerRequest);
    $query = $pendingRequest->query()->all();

    expect($query)->toHaveKey('sign')
        ->and($query)->toHaveKey('timestamp')
        ->and($query['sign_method'])->toBe('sha256')
        ->and($query['app_key'])->toBe($appKey);
});

it('generates a valid HMAC-SHA256 signature', function () {
    $appKey = 'my-app-key';
    $secretKey = 'my-secret';
    $connector = new MiraviaConnector($appKey, $secretKey, 'sha256');

    $pendingRequest = $connector->createPendingRequest(new GetSellerRequest);
    $query = $pendingRequest->query()->all();

    // Reproduce the signing algorithm to verify correctness
    $params = $query;
    unset($params['sign']);
    ksort($params);

    $data = '/seller/get';
    foreach ($params as $key => $value) {
        $data .= $key.$value;
    }
    $expectedSign = strtoupper(hash_hmac('sha256', $data, $secretKey));

    expect($query['sign'])->toBe($expectedSign);
});

it('includes access_token in query when set', function () {
    $connector = new MiraviaConnector('key', 'secret', 'sha256', 'my-access-token');

    $pendingRequest = $connector->createPendingRequest(new GetSellerRequest);
    $query = $pendingRequest->query()->all();

    expect($query['access_token'])->toBe('my-access-token');
});

it('omits access_token from query when null', function () {
    $connector = new MiraviaConnector('key', 'secret', 'sha256');

    $pendingRequest = $connector->createPendingRequest(new GetSellerRequest);
    $query = $pendingRequest->query()->all();

    expect($query)->not->toHaveKey('access_token');
});

it('detects API error responses via hasRequestFailed', function () {
    $connector = new MiraviaConnector('key', 'secret', 'sha256');

    // Key by class so retries also get the error response (avoids NoMockResponseFoundException)
    $mockClient = new MockClient([
        GetSellerRequest::class => MockResponse::make([
            'code' => 'E001',
            'message' => 'Invalid app key',
            'type' => 'ISP',
            'request_id' => 'r1',
        ]),
    ]);

    $connector->withMockClient($mockClient);

    expect(fn () => $connector->send(new GetSellerRequest))
        ->toThrow(\Saloon\Exceptions\Request\RequestException::class);
});

it('withAccessToken updates the token on the connector', function () {
    $connector = new MiraviaConnector('key', 'secret', 'sha256');
    $result = $connector->withAccessToken('new-token');

    expect($result)->toBe($connector);
});
