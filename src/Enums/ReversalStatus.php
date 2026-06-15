<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk\Enums;

use Deplox\MiraviaSdk\Enums\Concerns\NormalizesFromApi;

enum ReversalStatus: string
{
    use NormalizesFromApi;

    case RequestInitiate = 'request_initiate';
    case RequestReject = 'request_reject';
    case CancelRequest = 'cancel_request';
    case CancelCancel = 'cancel_cancel';
    case Success = 'success';
    case RefundPending = 'refund_pending';
    case RefundAuthorized = 'refund_authorized';
    case RefundSuccess = 'refund_success';
    case ReplacePending = 'replace_pending';
    case ReplaceReject = 'replace_reject';
    case ReplaceCommit = 'replace_commit';
    case ReplaceWaitAudit = 'replace_wait_audit';
    case SellerAgree = 'seller_agree';
    case SellerReject = 'seller_reject';
    case BuyerReturnItem = 'buyer_return_item';
    case ReturnSellerReject = 'return_seller_reject';
    case ReturnPending = 'return_pending';
    case ReturnSuccess = 'return_success';
    case SellerAgreeRefund = 'seller_agree_refund';
    case SellerRejectRefund = 'seller_reject_refund';
    case CsApproving = 'cs_approving';
    case AgreeCancel = 'agree_cancel';
    case OrderReject = 'order_reject';
    case CancelOrder = 'cancel_order';
    case RefundReject = 'refund_reject';
    case RequestCancel = 'request_cancel';
    case SellerAgreeReturn = 'seller_agree_return';

    /**
     * UI severity for PrimeVue status tags. Kept on the backend so frontend
     * stays in sync when cases are added/renamed.
     */
    public function severity(): string
    {
        return match ($this) {
            self::Success,
            self::RefundSuccess,
            self::ReturnSuccess,
            self::SellerAgree,
            self::SellerAgreeRefund,
            self::SellerAgreeReturn,
            self::ReplaceCommit,
            self::AgreeCancel => 'success',

            self::RefundPending,
            self::ReturnPending,
            self::ReplacePending,
            self::CsApproving,
            self::BuyerReturnItem,
            self::RequestInitiate,
            self::ReplaceWaitAudit,
            self::RefundAuthorized => 'warn',

            self::RequestReject,
            self::SellerReject,
            self::SellerRejectRefund,
            self::ReturnSellerReject,
            self::RefundReject,
            self::OrderReject,
            self::ReplaceReject => 'danger',

            self::CancelRequest,
            self::CancelCancel,
            self::CancelOrder,
            self::RequestCancel => 'secondary',
        };
    }
}
