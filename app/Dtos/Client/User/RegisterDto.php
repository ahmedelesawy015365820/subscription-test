<?php


namespace App\Dtos\Client\User;


use App\Http\Requests\Client\User\RegisterRequest;

class RegisterDto
{

    public function __construct(
        public $name,
        public $email,
        public $password,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        $data = $request->validated();

        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );
    }

    public function toDatabase(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }

}
