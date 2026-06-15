<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Resources;

use Deplox\MiraviaSdk\Payloads\Finance\GetTransactionsPayload;
use Deplox\MiraviaSdk\Requests\Finance\GetPayoutsRequest;
use Deplox\MiraviaSdk\Requests\Finance\GetTransactionsRequest;
use Deplox\MiraviaSdk\Resource;
use Deplox\MiraviaSdk\Response;
use Carbon\CarbonInterface;

final class FinanceApi extends Resource
{
    /**
     * @see https://open.miravia.com/apps/doc/api?path=/finance/payout/status/get
     */
    public function payouts(CarbonInterface $createdAfter): Response
    {
        return $this->connector->send(
            new GetPayoutsRequest($createdAfter)
        );
    }

    /**
     * @see https://open.miravia.com/apps/doc/api?path=/finance/transaction/details/get
     */
    public function transactions(GetTransactionsPayload $payload): Response
    {
        return $this->connector->send(
            new GetTransactionsRequest($payload)
        );
    }
}
