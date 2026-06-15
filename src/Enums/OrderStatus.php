<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;

enum OrderStatus: string
{
    use NormalizesFromApi;

    case Unpaid = 'unpaid';
    case Pending = 'pending';
    case Repacked = 'repacked';
    case Packed = 'packed';
    case ReadyToShipPending = 'ready_to_ship_pending';
    case ReadyToShip = 'ready_to_ship';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case FailedDelivery = 'failed_delivery';
    case Returned = 'returned';
    case Canceled = 'canceled';
    case Failed = 'failed';
    case Lost = 'lost';
    case LostBy3PL = 'lost_by_3pl';
    case DamagedBy3PL = 'damaged_by_3pl';
    case NonReturnablePending = 'non_returnable_pending';
    case NonReturnableConfirmed = 'non_returnable_confirmed';
    case ShippedBackSuccess = 'shipped_back_success';

    /** Create from a Miravia API response value, normalizing cryptic aliases. */
    public static function fromApiValue(string $value): string
    {
        $normalized = strtolower($value);

        return match ($normalized) {
            'nrpending' => self::NonReturnablePending->value,
            'nrconfirmed' => self::NonReturnableConfirmed->value,
            default => ($case = self::tryFrom($normalized)) !== null ? $case->value : $normalized,
        };
    }
}
