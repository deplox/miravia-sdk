<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;
use Illuminate\Support\Str;

// @see https://open.miravia.com/apps/doc/api?path=/v2/product/get
// @see https://open.miravia.com/apps/doc/doc?nodeId=84&docId=253
enum ProductStatusRequest: string
{
    use NormalizesFromApi;

    case All = 'all';
    case Live = 'live';
    case Active = 'active'; // same as live?
    case Pending = 'pending';
    case Deleted = 'deleted';
    case Inactive = 'inactive';
    case Rejected = 'rejected';
    case SoldOut = 'sold_out';

    /** Value to send to the Miravia API */
    public function apiValue(): string
    {
        return match ($this) {
            self::SoldOut => 'sold-out',
            default => $this->value,
        };
    }

    protected static function normalizeValue(string $value): string
    {
        $normalized = strtolower($value);

        return $normalized === 'sold-out' ? self::SoldOut->value : $normalized;
    }

    public function title(): string
    {
        return Str::title($this->value);
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn (self $case): string => $case->value, self::cases());
    }
}
