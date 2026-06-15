<?php

declare(strict_types=1);

namespace Deplox\MiraviaSdk;

use Deplox\MiraviaSdk\Resources\FinanceApi;
use Deplox\MiraviaSdk\Resources\FulfillmentApi;
use Deplox\MiraviaSdk\Resources\OrdersApi;
use Deplox\MiraviaSdk\Resources\ProductV2Api;
use Deplox\MiraviaSdk\Resources\ReturnAndRefundApi;
use Deplox\MiraviaSdk\Resources\SellerApi;
use Deplox\MiraviaSdk\Resources\SystemApi;

class Miravia
{
    public function __construct(
        protected readonly MiraviaConnector $connector,
    ) {}

    public function financeApi(): FinanceApi
    {
        return new FinanceApi($this->connector);
    }

    public function fulfillmentApi(): FulfillmentApi
    {
        return new FulfillmentApi($this->connector);
    }

    public function ordersApi(): OrdersApi
    {
        return new OrdersApi($this->connector);
    }

    public function productV2Api(): ProductV2Api
    {
        return new ProductV2Api($this->connector);
    }

    public function returnAndRefundApi(): ReturnAndRefundApi
    {
        return new ReturnAndRefundApi($this->connector);
    }

    public function sellerApi(): SellerApi
    {
        return new SellerApi($this->connector);
    }

    public function systemApi(): SystemApi
    {
        return new SystemApi($this->connector);
    }
}
