<?php

namespace App\Traits\Auth;

trait HashTrait
{
    public function encryptPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function comparePassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
