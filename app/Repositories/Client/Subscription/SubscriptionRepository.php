<?php


namespace App\Repositories\Client\Subscription;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionRepository implements  SubscriptionRepositoryInterface
{

    public function create($data)
    {
        return Subscription::create($data);
    }

    public function createFreeSubscription(User $user,Plan $plan)
    {
        return Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'status' => 'trialing',
            'ends_at' => now()->addDays(7)
        ]);
    }

}
