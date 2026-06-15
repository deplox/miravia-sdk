<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Resources;

use Deplox\MiraviaSdk\Requests\System\GenerateAccessTokenRequest;
use Deplox\MiraviaSdk\Requests\System\RefreshAccessTokenRequest;
use Deplox\MiraviaSdk\Resource;
use Deplox\MiraviaSdk\Response;

final class SystemApi extends Resource
{
    /**
     * @see https://open.miravia.com/apps/doc/api?path=/auth/token/create
     * @see https://open.miravia.com/apps/doc/doc?nodeId=30655&docId=120904
     */
    public function generateAccessToken(string $code): Response
    {
        $this->withAccessToken(null);

        return $this->connector->send(
            new GenerateAccessTokenRequest($code)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/auth/token/refresh
     * @see https://open.miravia.com/apps/doc/doc?nodeId=30655&docId=120904
     */
    public function refreshAccessToken(string $refreshToken): Response
    {
        $this->withAccessToken(null);

        return $this->connector->send(
            new RefreshAccessTokenRequest($refreshToken)
        );
    }
}
