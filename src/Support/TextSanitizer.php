<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Support;

use Illuminate\Support\Str;

/**
 * Normalizes free-text values arriving from the Miravia API before they are
 * persisted: decodes HTML entities, strips embedded HTML, removes invisible
 * unicode, and collapses whitespace. Empty results are normalized to `null`
 * so that columns nullable in storage do not end up with `""`.
 */
final class TextSanitizer
{
    public static function clean(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = strip_tags($value);
        $value = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $value) ?? $value;
        $value = Str::squish($value);

        return $value === '' ? null : $value;
    }
}
