<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailVarificationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Services\AuthService;

class AuthController extends Controller
{
    public $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRequest $request)
    {
        return $this->success(
            $this->authService->register($request->validated()),
            "User registered successfully!",
            201,
        );
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }

    public function emailVarification(EmailVarificationRequest $request)
    {
        return $this->authService->verifyOtp($request->validated());
    }
}
