<?php

namespace App\Repositories\Client\User;

use App\Dtos\Client\User\RegisterDto;

interface AuthRepositoryInterface
{
    public function create(RegisterDto $dto);
    public function findByEmail($email);
}
