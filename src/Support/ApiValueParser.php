<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Support;

/**
 * Normalizes raw scalar values arriving from the Miravia API into typed PHP
 * values. Miravia frequently returns booleans as the string literals "true"
 * and "false", monetary amounts with a European decimal comma, and array
 * fields as `null` or non-array scalars — the native PHP casts cannot deal
 * with these consistently, so we centralize the workarounds here.
 */
final class ApiValueParser
{
    /**
     * The native (bool) cast treats every non-empty string as true, so string
     * forms ("true"/"false"/"0"/"1") need to be normalized explicitly first.
     */
    public static function bool(mixed $value): bool
    {
        if (is_string($value)) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        return (bool) $value;
    }

    /**
     * Miravia returns monetary amounts as strings with a European decimal
     * comma (e.g. "-12,35"). Normalize to float, treating null/empty as 0.0.
     */
    public static function amount(mixed $value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        return (float) str_replace(',', '.', (string) $value);
    }

    /**
     * Miravia occasionally returns country fields as null or a scalar instead
     * of an array. Normalize defensively to a list of strings.
     *
     * @return list<string>
     */
    public static function countries(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, 'is_string'));
    }

    /**
     * Miravia encodes `cancel_return_initiator` as `{actor}-{action}` (e.g.
     * `buyer-cancel`, `system-cancel`). When neither side has happened the
     * API returns the literal string `"null-null"` instead of an actual null,
     * which then gets persisted verbatim. Treat it (and any partial null
     * segment) as null.
     */
    public static function cancelReturnInitiator(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = (string) $value;

        if ($value === 'null-null' || str_starts_with($value, 'null-') || str_ends_with($value, '-null')) {
            return null;
        }

        return $value;
    }
}
