<?php


namespace App\Http\Requests\Administrator\Plan;

use App\Dtos\Administrator\Plan\PlanDto;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use App\Enums\BillingCycle;
use App\Enums\Currency;

class PlanRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:1000000000',
            'currency' => ['required',Rule::enum(Currency::class)],
            'billing_cycle' => ['required',Rule::enum(BillingCycle::class)],
            'days' => 'nullable|integer|min:0|max:1000000000',
            'is_default' => 'required|in:0,1',
        ];
    }

    public function dto(): string
    {
        return PlanDto::class;
    }

}
