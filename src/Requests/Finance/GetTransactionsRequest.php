<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\Finance;

use Deplox\MiraviaSdk\Objects\Finance\TransactionCollection;
use Deplox\MiraviaSdk\Payloads\Finance\GetTransactionsPayload;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/finance/transaction/details/get
 */
final class GetTransactionsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected GetTransactionsPayload $payload,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'start_time' => $this->payload->startTime?->toDateString(),
            'end_time' => $this->payload->endTime?->toDateString(),
            'trans_type' => $this->payload->transactionType?->value,
            'trade_order_id' => $this->payload->tradeOrderId,
            'trade_order_line_id' => $this->payload->tradeOrderLineId,
            'offset' => $this->payload->offset,
            'limit' => $this->payload->limit,
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/finance/transaction/details/get';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return TransactionCollection::fromApiResponse($response->array('data') ?? []);
    }
}
