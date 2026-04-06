<?php

namespace App\Dtos\Client\Subscription;

use App\Http\Requests\Client\Subscription\SubscriptionRequest;

class SubscriptionDto
{
    public function __construct(
        public int $plan_id,
        public int $is_payment,
    ) {}

    public static function fromRequest(SubscriptionRequest $request): self
    {
        $data = $request->validated();

        return new self(
            plan_id: (int)$data['plan_id'],
            is_payment: (int)$data['is_payment']
        );
    }

    public function toArray(): array
    {
        return [
            'plan_id' => $this->plan_id,
            'is_payment' => $this->is_payment,
        ];
    }
}
