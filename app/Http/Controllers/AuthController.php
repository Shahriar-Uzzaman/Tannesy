<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(UserRequest $request)
    {
        return $this->authService->register($request->validated());
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }
}
