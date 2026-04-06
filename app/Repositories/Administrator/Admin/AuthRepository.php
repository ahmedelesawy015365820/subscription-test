<?php


namespace App\Repositories\Administrator\Admin;


use App\Models\Admin;
use App\Dtos\Administrator\Admin\RegisterDto;

class AuthRepository implements  AuthRepositoryInterface
{

    public function create(RegisterDto $dto)
    {
        return Admin::create($dto->toDatabase());
    }

    public function findByEmail($email)
    {
        return Admin::where('email', $email)->first();
    }

}
