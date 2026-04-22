<?php

namespace App\Http\Requests\Payment;

use App\Dtos\PaymentDTO;
use App\Http\Requests\BaseRequest;

class PaymentRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'sometimes|date',
        ];
    }

    public function dto(): string
    {
        return PaymentDTO::class;
    }
}
