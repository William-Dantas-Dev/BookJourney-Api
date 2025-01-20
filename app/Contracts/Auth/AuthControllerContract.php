<?php

namespace App\Contracts\Auth;

use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Requests\Auth\RegisterAuthRequest;
use App\Http\Requests\V1\Auth\RegisterAuthRequest as AuthRegisterAuthRequest;
use Illuminate\Http\Request;

interface AuthControllerContract
{
    public function register(AuthRegisterAuthRequest $request);
    // public function login(LoginAuthRequest $request);
    // public function logout(Request $request);
}
