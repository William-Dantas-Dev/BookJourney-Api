<?php

namespace App\Repositories\V1;

use App\Contracts\Auth\AuthRepositoryContract;
use App\DTO\AuthDTO;
use App\Models\User;

class AuthRepository implements AuthRepositoryContract
{
    public function register(AuthDTO $authDTO)
    {
        return User::create($authDTO->toArray());
    }

    public function login(User $user)
    {
        return $user->createToken($user->name);
    }

    public function logout(User $user)
    {
        return $user->tokens()->delete();
    }
}
