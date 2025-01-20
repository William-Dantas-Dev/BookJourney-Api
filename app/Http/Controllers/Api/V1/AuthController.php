<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\AuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginAuthRequest;
use App\Http\Requests\V1\Auth\RegisterAuthRequest;
use Illuminate\Http\Request;
use App\Services\V1\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterAuthRequest $request)
    {
        try {
            $user = $this->authService->register(AuthDTO::fromArray($request->all()));

            if ($user) {
                return response()->json([
                    'message' => 'User registered successfully.',
                    'user' => $user
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Failed to register user.'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error registering user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(LoginAuthRequest $request)
    {
        try {
            $result = $this->authService->login(AuthDTO::fromArray($request->all()));

            if (isset($result['error'])) {
                return response()->json([
                    'message' => $result['error']
                ], 401);
            }

            return response()->json([
                'user' => $result['user'],
                'token' => $result['token']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $result = $this->authService->logout($request->user());

            if (isset($result['error'])) {
                return response()->json([
                    'message' => $result['error']
                ], 400);
            }

            return response()->json([
                'message' => $result['message']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
