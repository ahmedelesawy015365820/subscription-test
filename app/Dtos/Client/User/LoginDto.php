<?php


namespace App\Dtos\Client\User;

use App\Http\Requests\Client\User\LoginRequest;

class LoginDto
{

    public function __construct(
        public $email,
        public $password,
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        $data = $request->validated();

        return new self(
            email: $data['email'],
            password: $data['password']
        );
    }

    public function toDatabase(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

}
