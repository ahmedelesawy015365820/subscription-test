<?php

namespace App\Http\Requests\Subscription;

use App\Dtos\SubscriptionDTO;
use App\Http\Requests\BaseRequest;
use App\Enums\SubscriptionStatus;
use Illuminate\Validation\Rule;

class SubscriptionRequest extends BaseRequest
{
    public function rules(): array
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'plan_id' => 'required|exists:plans,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['customer_id'] = 'sometimes|required|exists:customers,id';
            $rules['plan_id'] = 'sometimes|required|exists:plans,id';
            $rules['status'] = ['sometimes', 'required', Rule::enum(SubscriptionStatus::class)];
        }

        return $rules;
    }

    public function dto(): string
    {
        return SubscriptionDTO::class;
    }
}
