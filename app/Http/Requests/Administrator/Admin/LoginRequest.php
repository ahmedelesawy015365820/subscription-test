<?php


namespace App\Http\Requests\Administrator\Admin;

use App\Dtos\Administrator\Admin\LoginDto;
use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string|min:8|max:20',
        ];
    }

    public function dto(): string
    {
        return LoginDto::class;
    }

}
