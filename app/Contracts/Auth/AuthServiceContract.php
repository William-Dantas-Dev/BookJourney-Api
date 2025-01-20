<?php

namespace App\Contracts\Auth;

use App\DTO\AuthDTO;
use App\Models\User;

interface AuthServiceContract
{
    public function register(AuthDTO $authDTO);
    // public function login(AuthDTO $authDTO);
    // public function logout(User $user);
}
