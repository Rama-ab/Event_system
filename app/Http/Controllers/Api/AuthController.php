<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\AuthService;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequeest;
use App\Http\Requests\Auth\RegisterUserRequest;

class AuthController extends Controller
{   public function __construct(protected AuthService $authService) {}

public function register(RegisterUserRequest $request)
{
    $result = $this->authService->register($request->validated());
    return response()->json([
        'message' => 'User registered successfully.',
        'user' => $result['user'],
        'token' => $result['token'],
        'role' => $result['user']->getRoleNames()
    ], 201);
}

public function login(LoginRequeest $request)
{
    $result = $this->authService->login($request->validated());
    return response()->json([
        'message' => 'Login successful.',
        'user' => $result['user'],
        'token' => $result['token'],
        'role' => $result['user']->getRoleNames()
    ]);
}

public function logout(Request $request)
{
    $this->authService->logout($request->user());
    return response()->json(['message' => 'Logged out successfully.']);
}

}
