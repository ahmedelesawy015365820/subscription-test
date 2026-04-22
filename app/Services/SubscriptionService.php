<?php

namespace App\Services;

use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use App\Repositories\Contracts\PlanRepositoryInterface;
use App\Dtos\SubscriptionDTO;
use App\Enums\SubscriptionStatus;
use Carbon\Carbon;

class SubscriptionService extends BaseService
{
    protected SubscriptionRepositoryInterface $subscriptionRepository;
    protected PlanRepositoryInterface $planRepository;

    public function __construct(
        SubscriptionRepositoryInterface $subscriptionRepository,
        PlanRepositoryInterface $planRepository
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->planRepository = $planRepository;
    }

    public function getAllSubscriptions()
    {
        return $this->subscriptionRepository->all();
    }

    public function getSubscription($id)
    {
        return $this->subscriptionRepository->find($id);
    }

    public function createSubscription(SubscriptionDTO $dto)
    {
        return $this->execute(function () use ($dto) {
            $data = $dto->toArray();
            
            // Get the plan to calculate start and end dates
            $plan = $this->planRepository->find($data['plan_id']);
            
            if (!isset($data['start_date'])) {
                $data['start_date'] = Carbon::now();
            } else {
                $data['start_date'] = Carbon::parse($data['start_date']);
            }

            if (!isset($data['end_date'])) {
                if ($plan->billing_cycle === 'monthly') {
                    $data['end_date'] = $data['start_date']->copy()->addMonth();
                } elseif ($plan->billing_cycle === 'yearly') {
                    $data['end_date'] = $data['start_date']->copy()->addYear();
                } else {
                    $data['end_date'] = $data['start_date']->copy()->addMonth();
                }
            }

            // Set initial status to active
            $data['status'] = SubscriptionStatus::ACTIVE->value;

            return $this->subscriptionRepository->create($data);
        });
    }

    public function updateSubscription($id, SubscriptionDTO $dto)
    {
        return $this->execute(function () use ($id, $dto) {
            return $this->subscriptionRepository->update($id, $dto->toArray());
        });
    }

    public function changeStatus($id, string $status)
    {
        return $this->execute(function () use ($id, $status) {
            $subscription = $this->subscriptionRepository->find($id);
            if ($subscription) {
                return $subscription->update(['status' => $status]);
            }
            return false;
        });
    }

    public function cancelSubscription($id)
    {
        return $this->changeStatus($id, SubscriptionStatus::CANCELED->value);
    }

    public function activateSubscription($id)
    {
        return $this->changeStatus($id, SubscriptionStatus::ACTIVE->value);
    }

    public function deleteSubscription($id)
    {
        return $this->execute(function () use ($id) {
            return $this->subscriptionRepository->delete($id);
        });
    }
}
