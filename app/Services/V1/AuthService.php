<?php

namespace App\Services\V1;

use App\Contracts\Auth\AuthServiceContract;
use App\DTO\AuthDTO;
use App\Models\User;
use App\Repositories\V1\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceContract
{
    protected $AuthRepository;

    public function __construct(AuthRepository $AuthRepository)
    {
        $this->AuthRepository = $AuthRepository;
    }

    public function register(AuthDTO $authDTO)
    {
        $user = $this->AuthRepository->register($authDTO);
        $token = $user->createToken($user->name);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login(AuthDTO $authDTO)
    {
        $user = User::where('email', $authDTO->email)->first();

        if (!$user || !Hash::check($authDTO->password, $user->password)) {
            return [
                'error' => 'Invalid credentials'
            ];
        }

        $token = $this->AuthRepository->login($user);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout(User $user)
    {
        $this->AuthRepository->logout($user);

        return [
            'message' => 'Logged out successfully'
        ];
    }
}
