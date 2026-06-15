<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

enum TransactionType: int
{
    case ShippingFeePaid = 7;
    case ItemPriceCredit = 13;
    case ReversalItemPriceCredit = 14;
    case ReversalCommission = 15;
    case Commission = 16;
    case PromotionalChargesBundles = 117;
    case PromotionalChargesVouchers = 118;
    case ReversalPromotionalChargesBundlesArise = 120;
    case ReversalPromotionalChargesVouchersArise = 121;
    case ReversalVAT = 166;
    case AutoShippingFeeSubsidyBySeller = 167;
    case ShippingFee = 168;
    case ReversalShippingFees = 170;
    case PromotionalChargesFlexiCombo = 209;
    case ReversalPromotionalChargesFlexiComboArise = 210;
    case VAT = 2020;
    case ImportFee = 2030;
    case ReversalImportFee = 2040;
    case AdjustmentItemPrice = 5001;
    case AdjustmentShippingFee = 5003;
    case AdjustmentCommission = 5005;
    case AdjustmentReversalItemPrice = 5007;
    case AdjustmentReversalShippingFee = 5009;
    case AdjustmentReversalCommission = 5011;
    case AdjustmentShippingFeePaidBySeller = 5013;
    case ItemPriceClaim = 5015;
    case ShippingFeeClaim = 5017;
    case OtherClaim = 5019;
    case ReversalShippingFeeSubsidy = 5021;
    case FulfillmentFee = 5023;
    case StorageFee = 5025;
    case EprFee = 6100;
    case EprServiceFee = 6110;
    case ReversalEprFee = 6200;
    case ReversalEprServiceFee = 6210;
}
