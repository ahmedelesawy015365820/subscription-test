<?php


namespace App\Repositories\Client\User;

use App\Dtos\Administrator\Admin\RegisterDto;
use App\Models\User;

class AuthRepository implements  AuthRepositoryInterface
{

    public function create(RegisterDto $dto)
    {
        return User::create($dto->toDatabase());
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

}
