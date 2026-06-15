<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;

enum Currency: string
{
    use NormalizesFromApi;

    protected static function normalizeValue(string $value): string
    {
        return strtoupper($value);
    }
    case EUR = 'EUR';
    case USD = 'USD';
    case GBP = 'GBP';
    case CAD = 'CAD';
    case CHF = 'CHF';
    case BRL = 'BRL';
    case PLN = 'PLN';
    case TRY = 'TRY';
    case MXN = 'MXN';
    case AUD = 'AUD';
    case SEK = 'SEK';
    case SAR = 'SAR';
    case AED = 'AED';
    case INR = 'INR';

    public function symbol(): string
    {
        return match ($this) {
            self::EUR => '€',
            self::USD => '$',
            self::GBP => '£',
            self::CAD => 'C$',
            self::CHF => 'Fr.',
            self::BRL => 'R$',
            self::PLN => 'zł',
            self::TRY => '₺',
            self::MXN => '$',
            self::AUD => 'A$',
            self::SEK => 'kr',
            self::SAR => '﷼',
            self::AED => 'د.إ',
            self::INR => '₹',
        };
    }
}
