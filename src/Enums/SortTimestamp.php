<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

enum SortTimestamp: string
{
    case Created = 'created_at';
    case Updated = 'updated_at';
}
