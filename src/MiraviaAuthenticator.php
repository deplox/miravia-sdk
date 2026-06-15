<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk;

use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

final readonly class MiraviaAuthenticator implements Authenticator
{
    public function __construct(
        protected string $appKey,
        #[\SensitiveParameter] protected ?string $accessToken = null,
    ) {}

    public function set(PendingRequest $pendingRequest): void
    {
        $pendingRequest->query()->add('app_key', $this->appKey);

        if ($this->accessToken) {
            $pendingRequest->query()->add('access_token', $this->accessToken);
        }
    }
}
