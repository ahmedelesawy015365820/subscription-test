<?php

namespace App\Http\Requests\Invoice;

use App\Dtos\InvoiceDTO;
use App\Http\Requests\BaseRequest;
use App\Enums\InvoiceStatus;
use Illuminate\Validation\Rule;

class InvoiceRequest extends BaseRequest
{
    public function rules(): array
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => ['required', Rule::enum(InvoiceStatus::class)],
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules = [
                'customer_id' => 'sometimes|required|exists:customers,id',
                'subscription_id' => 'sometimes|required|exists:subscriptions,id',
                'amount' => 'sometimes|required|numeric|min:0',
                'due_date' => 'sometimes|required|date',
                'status' => ['sometimes', 'required', Rule::enum(InvoiceStatus::class)],
            ];
        }

        return $rules;
    }

    public function dto(): string
    {
        return InvoiceDTO::class;
    }
}
