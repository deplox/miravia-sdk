<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Middlewares;

use DateTimeImmutable;
use Saloon\Contracts\RequestMiddleware;
use Saloon\Http\PendingRequest;

final readonly class SignRequest implements RequestMiddleware
{
    public function __construct(
        public string $signMethod,
        #[\SensitiveParameter] public string $secretKey,
    ) {}

    public function __invoke(PendingRequest $pendingRequest): void
    {
        $pendingRequest->query()->add('sign_method', $this->signMethod);
        $pendingRequest->query()->add('timestamp', $this->generateTimestamp());
        $pendingRequest->query()->add('sign', $this->generateSignature($pendingRequest));
    }

    protected function generateSignature(PendingRequest $pendingRequest): string
    {
        /** @var array<string,string> $params */
        $params = $pendingRequest->query()->all();

        ksort($params);

        $data = $pendingRequest->getRequest()->resolveEndpoint();
        foreach ($params as $key => $value) {
            $data .= $key.$value;
        }

        return strtoupper(
            hash_hmac($this->signMethod, $data, $this->secretKey)
        );
    }

    protected function generateTimestamp(): int
    {
        return (int) (new DateTimeImmutable)->format('Uv');
    }
}
