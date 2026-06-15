<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;
use Illuminate\Support\Str;

/**
 * @see https://open.miravia.com/apps/doc/api?path=/products/get
 * @see https://open.miravia.com/apps/doc/api?path=/product/item/get
 * @see https://open.miravia.com/apps/doc/api?path=/v2/product/get
 * @see https://open.miravia.com/apps/doc/doc?nodeId=84&docId=253
 * @see https://open.miravia.com/apps/announcement/detail?docId=337
 */
enum ProductStatus: string
{
    use NormalizesFromApi;

    case Active = 'active'; // online
    case Inactive = 'inactive'; // offline
    case Draft = 'draft'; // ?
    case Suspended = 'suspended';
    case PendingQC = 'pending_qc';
    case Deleted = 'deleted';

    public function title(): string
    {
        return Str::title($this->value);
    }

    public static function values(): array
    {
        return array_map(fn (self $case): string => $case->value, self::cases());
    }
}
