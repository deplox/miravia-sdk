<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Requests\ReturnAndRefund;

use Deplox\MiraviaSdk\Objects\ReturnAndRefund\ReversalCollection;
use Deplox\MiraviaSdk\Payloads\ReturnAndRefund\GetReversalsPayload;
use Deplox\MiraviaSdk\Request;
use Saloon\Enums\Method;
use Saloon\Http\Response;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/reverse/getreverseordersforseller
 */
final class GetReversalsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected GetReversalsPayload $payload,
    ) {}

    protected function defaultQuery(): array
    {
        return $this->filterQueryParameters([
            'page_no' => $this->payload->pageNo,
            'page_size' => $this->payload->pageSize,
            'ofc_status_list' => $this->payload->ofcStatusList,
            'reverse_status_list' => $this->payload->reverseStatusList,
            'reverse_order_id' => $this->payload->reverseOrderId,
            'trade_order_id' => $this->payload->tradeOrderId,
            'reverse_order_line_time_range_start_time_stamp' => $this->payload->reverseOrderLineStartTime?->getTimestampMs(),
            'reverse_order_line_time_range_end_time_stamp' => $this->payload->reverseOrderLineEndTime?->getTimestampMs(),
            'trade_order_time_range_start_time_stamp' => $this->payload->tradeOrderStartTime?->getTimestampMs(),
            'trade_order_time_range_end_time_stamp' => $this->payload->tradeOrderEndTime?->getTimestampMs(),
            'dispute_in_progress' => $this->payload->disputeInProgress,
            'reverse_tracking_number' => $this->payload->reverseTrackingNumber,
            'marketplace' => $this->payload->marketplace?->apiValue(),
        ]);
    }

    public function resolveEndpoint(): string
    {
        return '/reverse/getreverseordersforseller';
    }

    public function createDtoFromResponse(Response $response): mixed
    {
        return ReversalCollection::fromApiResponse($response->array('data'));
    }
}
