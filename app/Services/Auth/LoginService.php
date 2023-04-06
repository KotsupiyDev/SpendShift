<?php

namespace App\Services\Auth;

use App\DTO\UserDTO;
use App\Models\User;
use App\Traits\Auth\HashTrait;
use Exception;

class LoginService
{
    use HashTrait;

    public function login(UserDTO $userDTO): array
    {
        $user = User::where('email', $userDTO->email)->first();

        throw_if(is_null($user), new Exception('User does not exist!'));

        $isCorrectPassword = $this->comparePassword($userDTO->password, $user->password);

        throw_if(!$isCorrectPassword, new Exception('Password is incorrect!'));

        $token = $user->createToken('auth');

        return [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token->plainTextToken,
        ];
    }
}
