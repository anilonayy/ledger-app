<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function __construct(private readonly AuthServiceInterface $authService)
    {
    }


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return Api::ok($this->authService->login((object) $request->validated()));
    }


    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return Api::ok($this->authService->register((object) $request->validated()));
    }
}
