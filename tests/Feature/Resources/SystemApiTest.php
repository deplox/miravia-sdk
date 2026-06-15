<?php

declare(strict_types=1);

use Deplox\MiraviaSdk\MiraviaConnector;
use Deplox\MiraviaSdk\Objects\System\AccessToken;
use Deplox\MiraviaSdk\Resources\SystemApi;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function tokenResponse(): array
{
    return [
        'code' => '0',
        'country' => 'ES',
        'account_platform' => 'miravia',
        'access_token' => 'new-access-token',
        'expires_in' => '7776000',   // 90 days — well above the 7-day refresh threshold
        'refresh_token' => 'new-refresh-token',
        'refresh_expires_in' => '31536000', // 365 days
    ];
}

it('generateAccessToken() returns an AccessToken DTO', function () {
    $connector = new MiraviaConnector('key', 'secret', 'sha256');
    $mockClient = new MockClient([MockResponse::make(tokenResponse())]);
    $connector->withMockClient($mockClient);

    $token = (new SystemApi($connector))->generateAccessToken('auth-code')->dto();

    expect($token)->toBeInstanceOf(AccessToken::class)
        ->and($token->accessToken)->toBe('new-access-token')
        ->and($token->refreshToken)->toBe('new-refresh-token')
        ->and($token->countryCode)->toBe('es')
        ->and($token->accountPlatform)->toBe('miravia');
});

it('generateAccessToken() sets expiry relative to now', function () {
    $connector = new MiraviaConnector('key', 'secret', 'sha256');
    $mockClient = new MockClient([MockResponse::make(tokenResponse())]);
    $connector->withMockClient($mockClient);

    $token = (new SystemApi($connector))->generateAccessToken('code')->dto();

    expect($token->accessTokenExpiresAt->isFuture())->toBeTrue()
        ->and($token->refreshTokenExpiresAt->isFuture())->toBeTrue();
});

it('refreshAccessToken() returns an AccessToken DTO', function () {
    $connector = new MiraviaConnector('key', 'secret', 'sha256');
    $mockClient = new MockClient([MockResponse::make(tokenResponse())]);
    $connector->withMockClient($mockClient);

    $token = (new SystemApi($connector))->refreshAccessToken('old-refresh-token')->dto();

    expect($token)->toBeInstanceOf(AccessToken::class)
        ->and($token->accessToken)->toBe('new-access-token');
});

it('accessTokenExpiresSoon() returns false for fresh token', function () {
    $connector = new MiraviaConnector('key', 'secret', 'sha256');
    $mockClient = new MockClient([MockResponse::make(tokenResponse())]);
    $connector->withMockClient($mockClient);

    $token = (new SystemApi($connector))->generateAccessToken('code')->dto();

    expect($token->accessTokenExpiresSoon())->toBeFalse();
});
