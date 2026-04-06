<?php


namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\BaseController;
use App\Enums\PaymentStatus;
use App\Enums\Currency;
use App\Enums\BillingCycle;
use App\Enums\SubscriptionStatus;

class EnumsController extends BaseController
{

    public function getBillingCycle()
    {
        return $this->responseJson(BillingCycle::toDictionary(), 'fetch data', 200
        );
    }

    public function getCurrency()
    {
        return $this->responseJson(Currency::toDictionary(), 'fetch data', 200);
    }

    public function getPaymentStatus()
    {
        return $this->responseJson(PaymentStatus::toDictionary(), 'fetch data', 200);
    }

    public function getSubscriptionStatus()
    {
        return $this->responseJson(SubscriptionStatus::toDictionary(), 'fetch data', 200);
    }

}
