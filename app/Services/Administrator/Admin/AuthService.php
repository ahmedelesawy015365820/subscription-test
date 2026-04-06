<?php


namespace App\Services\Administrator\Admin;

use App\Dtos\Administrator\Admin\LoginDto;
use App\Dtos\Administrator\Admin\RegisterDto;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Administrator\Admin\AuthRepositoryInterface;

class AuthService extends BaseService
{

    public function __construct(
        private AuthRepositoryInterface $repo
    ) {}

    public function register(RegisterDto $data)
    {
        return $this->execute(function () use ($data) {

            $admin = $this->repo->create($data);
            $token = $admin->createToken('admin_token')->plainTextToken;

            return compact('admin', 'token');
        });
    }

    public function login(LoginDTO $data)
    {
        return $this->execute(function () use ($data) {
            $admin = $this->repo->findByEmail($data->email);

            if (!$admin || !Hash::check($data->password, $admin->password)) {
                return response()->json(['status' => false, 'message' => 'Invalid credentials'], 400);
            }

            $token = $admin->createToken('admin_token')->plainTextToken;

            return compact('admin', 'token');
        });
    }

}
