<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Resources;

use Deplox\MiraviaSdk\Payloads\ReturnAndRefund\GetReversalsPayload;
use Deplox\MiraviaSdk\Requests\ReturnAndRefund\GetReversalsRequest;
use Deplox\MiraviaSdk\Resource;
use Deplox\MiraviaSdk\Response;

final class ReturnAndRefundApi extends Resource
{
    /**
     * @see https://open.miravia.com/apps/doc/api?path=/reverse/getreverseordersforseller
     * @see https://open.miravia.com/apps/doc/doc?nodeId=37788&docId=121056
     */
    public function list(GetReversalsPayload $payload): Response
    {
        return $this->connector->send(
            new GetReversalsRequest($payload)
        );
    }
}
