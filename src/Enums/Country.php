<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;

enum Country: string
{
    use NormalizesFromApi;

    case Spain = 'es';
    case Italy = 'it';
    case Portugal = 'pt';
}
