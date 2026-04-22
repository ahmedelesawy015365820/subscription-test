<?php

namespace App\Http\Requests\Plan;

use App\Dtos\PlanDTO;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use App\Enums\BillingCycle;

class PlanRequest extends BaseRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => ['required', Rule::enum(BillingCycle::class)],
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = 'sometimes|required|string|max:255';
            $rules['price'] = 'sometimes|required|numeric|min:0';
            $rules['billing_cycle'] = ['sometimes', 'required', Rule::enum(BillingCycle::class)];
        }

        return $rules;
    }

    public function dto(): string
    {
        return PlanDTO::class;
    }
}
