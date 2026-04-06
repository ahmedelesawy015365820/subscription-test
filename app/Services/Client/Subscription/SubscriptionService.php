<?php


namespace App\Services\Client\Subscription;

use App\Dtos\Client\Subscription\SubscriptionDto;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Client\Plan\PlanRepositoryInterface;
use App\Repositories\Client\Subscription\SubscriptionRepositoryInterface;
use App\Enums\SubscriptionStatus;

class SubscriptionService extends BaseService
{

    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepo,
        private PlanRepositoryInterface $planRepo,
    ) {}

    public function subscription(SubscriptionDto $data)
    {
        return $this->execute(function () use ($data) {

            $user = Auth::guard('user')->user();

            $plan = $this->planRepo->find($data->plan_id);

            if($data->is_payment){
                $user = $this->subscriptionRepo->create([
                    'plan_id' => $plan->id,
                    'user_id' => $user->id,
                    'status' => SubscriptionStatus::ACTIVE,
                    'ends_at' => now()->addDays($plan->days)
                ]);

                return 'Subscription successful';
            }else {
                $user = $this->subscriptionRepo->create([
                    'plan_id' => $plan->id,
                    'user_id' => $user->id,
                    'status' => SubscriptionStatus::PAST_DUE,
                    'grace_period_ends_at' => now()->addDays(3)
                ]);

                return "The grace period ends after 3 o'clock";
            }
        });
    }

}
