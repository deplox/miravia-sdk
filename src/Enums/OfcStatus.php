<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;

enum OfcStatus: string
{
    use NormalizesFromApi;

    case ReturnPickupPending = 'return_pickup_pending';
    case ReturnDelivered = 'return_delivered';
    case ReturnTplReceived = 'return_tpl_received';
    case ReturnStock = 'return_stock';
    case ReturnStockAround = 'return_stock_around';
    case ReturnDcDone = 'return_dc_done';
    case ReturnLogisticClosure = 'return_logistic_closure';
    case Failed = 'failed';
}
