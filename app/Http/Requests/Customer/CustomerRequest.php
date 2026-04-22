<?php

namespace App\Http\Requests\Customer;

use App\Dtos\CustomerDTO;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends BaseRequest
{
    public function rules(): array
    {
        $customerId = $this->route('customer') ? $this->route('customer') : null;

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = 'sometimes|required|string|max:255';
            $rules['email'] = [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customerId)
            ];
        }

        return $rules;
    }

    public function dto(): string
    {
        return CustomerDTO::class;
    }
}
