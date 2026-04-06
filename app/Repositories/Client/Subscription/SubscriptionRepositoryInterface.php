<?php

namespace App\Repositories\Client\Subscription;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;

interface SubscriptionRepositoryInterface
{

    public function create($data);
    public function createFreeSubscription(User $user,Plan $plan);

}
