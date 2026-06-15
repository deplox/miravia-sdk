<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;

enum WarehouseStatus: string
{
    use NormalizesFromApi;

    case Active = 'active';
    case Inactive = 'inactive';
    case Deleted = 'deleted';
}
