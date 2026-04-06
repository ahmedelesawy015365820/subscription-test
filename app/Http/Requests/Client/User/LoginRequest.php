<?php


namespace App\Http\Requests\Client\User;

use App\Dtos\Client\User\LoginDto;
use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|max:20',
        ];
    }

    public function dto(): string
    {
        return LoginDto::class;
    }

}
