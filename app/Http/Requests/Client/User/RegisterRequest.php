<?php


namespace App\Http\Requests\Client\User;

use App\Dtos\Client\User\RegisterDto;
use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|max:20|confirmed',
        ];
    }

    public function dto(): string
    {
        return RegisterDto::class;
    }

}
