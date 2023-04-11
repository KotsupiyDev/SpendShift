<?php

namespace App\Services\Auth;

use App\DTO\UserDTO;
use App\Models\User;
use App\Traits\Auth\HashTrait;
use Faker\Factory;
use Illuminate\Support\Str;

class RegistrationService
{
    use HashTrait;

    public function register(UserDTO $userDTO): array
    {
        $hashPassword = $this->encryptPassword($userDTO->password);

        $user = User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'password' => $hashPassword,
        ]);

        $token = $user->createToken('auth')->plainTextToken;

        return [
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ];
    }

    public function makeGuestUser(string $email): UserDTO
    {
        $faker = Factory::create();

        return UserDTO::from([
            'name' => $faker->name(),
            'email' => $email,
            'password' => Str::random(16),
        ]);
    }
}
