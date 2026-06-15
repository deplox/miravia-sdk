<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;

/**
 * @see https://open.miravia.com/apps/announcement/detail?docId=337
 * @see https://open.miravia.com/apps/announcement/detail?docId=351
 */
enum Marketplace: string
{
    use NormalizesFromApi;

    case Miravia = 'miravia';
    case AliExpress = 'aliexpress'; // Miravia to AliExpress (m2a)

    /** Value to send to the Miravia API */
    public function apiValue(): string
    {
        return match ($this) {
            self::AliExpress => 'ae',
            default => $this->value,
        };
    }

    protected static function normalizeValue(string $value): string
    {
        $normalized = strtolower($value);

        return $normalized === 'ae' ? self::AliExpress->value : $normalized;
    }
}
