<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums\Concerns;

trait NormalizesFromApi
{
    /** Normalize an API value to the enum's backing value, or return the normalized input as-is if unknown. */
    public static function fromApiValue(string $value): string
    {
        $normalized = static::normalizeValue($value);
        $case = static::tryFrom($normalized);

        return $case !== null ? $case->value : $normalized;
    }

    protected static function normalizeValue(string $value): string
    {
        return strtolower($value);
    }
}
