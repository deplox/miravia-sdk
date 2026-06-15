<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk;

abstract class Resource
{
    public function __construct(
        public readonly MiraviaConnector $connector,
    ) {}

    public function withAccessToken(#[\SensitiveParameter] ?string $accessToken): static
    {
        $this->connector->withAccessToken($accessToken);

        return $this;
    }
}
