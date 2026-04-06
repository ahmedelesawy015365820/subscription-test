<?php

namespace App\Repositories\Administrator\Admin;

use App\Dtos\Administrator\Admin\RegisterDto;

interface AuthRepositoryInterface
{
    public function create(RegisterDto $dto);
    public function findByEmail($email);
}
