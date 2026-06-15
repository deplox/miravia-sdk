<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;

enum ReversalRequestType: string
{
    use NormalizesFromApi;

    case Cancel = 'cancel';
    case Return = 'return';
    case Replacement = 'replacement';
    case OnlyRefund = 'only_refund';
}
