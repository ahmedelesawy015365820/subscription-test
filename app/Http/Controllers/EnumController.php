<?php

namespace App\Http\Controllers;

use App\Enums\AccountType;
use App\Enums\BillingCycle;
use App\Enums\InvoiceStatus;
use App\Enums\SubscriptionStatus;
use App\Enums\UserRole;
use Illuminate\Http\JsonResponse;

class EnumController extends BaseController
{
    public function index(): JsonResponse
    {
        return $this->responseJson([
            'billing_cycles'      => BillingCycle::toDictionary(),
            'invoice_statuses'    => InvoiceStatus::toDictionary(),
            'subscription_statuses' => SubscriptionStatus::toDictionary(),
            'user_roles'         => UserRole::toDictionary(),
            'account_types'      => AccountType::toDictionary(),
        ], 'Enums retrieved successfully.');
    }
}
