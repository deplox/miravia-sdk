<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Objects\System;

use Deplox\MiraviaSdk\Enums\Country;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Date;

/** @implements Arrayable<string, mixed> */
final readonly class AccessToken implements Arrayable
{
    public function __construct(
        public string $countryCode,
        public string $accountPlatform,
        public string $accessToken,
        public CarbonInterface $accessTokenExpiresAt,
        public string $refreshToken,
        public CarbonInterface $refreshTokenExpiresAt,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromSetting(array $data): self
    {
        return new self(
            $data['country_code'],
            $data['account_platform'],
            $data['access_token'],
            Date::parse($data['access_token_expire']),
            $data['refresh_token'],
            Date::parse($data['refresh_token_expire']),
        );
    }

    /** @param array<string, mixed> $data */
    public static function fromApiResponse(array $data): self
    {
        return new self(
            Country::fromApiValue($data['country'] ?? ''),
            $data['account_platform'],
            $data['access_token'],
            Date::now()->addSeconds((int) $data['expires_in']),
            $data['refresh_token'],
            Date::now()->addSeconds((int) $data['refresh_expires_in']),
        );
    }

    public function toArray(): array
    {
        return [
            'country_code' => $this->countryCode,
            'account_platform' => $this->accountPlatform,
            'access_token' => $this->accessToken,
            'access_token_expire' => (string) $this->accessTokenExpiresAt,
            'refresh_token' => $this->refreshToken,
            'refresh_token_expire' => (string) $this->refreshTokenExpiresAt,
        ];
    }

    public function accessTokenExpiresSoon(): bool
    {
        return $this->accessTokenExpiresAt->isBefore(Date::now()->addDays($this->refreshThresholdDays()));
    }

    public function refreshTokenExpiresSoon(): bool
    {
        return $this->refreshTokenExpiresAt->isBefore(Date::now()->addDays($this->refreshThresholdDays()));
    }

    private function refreshThresholdDays(): int
    {
        return (int) config('miravia.access_token_refresh_threshold_days');
    }
}
