<?php


namespace App\Http\Requests\Client\Subscription;

use App\Dtos\Client\User\LoginDto;
use App\Http\Requests\BaseRequest;

class SubscriptionRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'plan_id' => 'required|exists:plans,id',
            'is_payment' => 'required|in:1,2',
        ];
    }

    public function dto(): string
    {
        return;
    }

}
