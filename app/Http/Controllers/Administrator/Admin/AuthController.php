<?php


namespace App\Http\Controllers\Administrator\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Administrator\Admin\LoginRequest;
use App\Http\Requests\Administrator\Admin\RegisterRequest;
use App\Services\Administrator\Admin\AuthService;

class AuthController extends BaseController
{
    public function __construct(
        private AuthService $service
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
