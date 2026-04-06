<?php


namespace App\Http\Controllers\Client\User;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Client\User\LoginRequest;
use App\Http\Requests\Client\User\RegisterRequest;
use App\Services\Client\User\AuthService;

class AuthController extends BaseController
{
    public function __construct(
        private AuthService $service,
    ){}

    public function register(RegisterRequest $request)
    {
        return $this->responseJson(
            $this->service->register($request->toDto()), 'Created Successfully', 200
        );
    }

    public function login(LoginRequest $request)
    {
        return $this->responseJson(
            $this->service->login($request->toDto()), 'fetch data', 200
        );
    }

}
