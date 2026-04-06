<?php


namespace App\Http\Controllers\Client\Subscription;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Client\Subscription\SubscriptionRequest;
use App\Http\Requests\Client\User\LoginRequest;
use App\Http\Requests\Client\User\RegisterRequest;
use App\Services\Client\User\AuthService;
use App\Services\Client\Subscription\SubscriptionService;

class SubscriptionController extends BaseController
{
    public function __construct(
        private SubscriptionService $Subscription,
    ){}

    public function create(SubscriptionRequest $request)
    {
        return $this->responseJson([], $this->Subscription->subscription($request->toDto()), 200);
    }

}
