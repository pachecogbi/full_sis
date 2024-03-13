<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Resources\Auth\RegisterResource;
use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Services\Auth\UserService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {
    }

    public function register(AuthRegisterRequest $request): RegisterResource | JsonResponse
    {
        try {
            return RegisterResource::make($this->userService->create($request->validated()));
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => $th->getCode(),
                'error' => $th->getMessage(),
                'trace' => $th->getTrace(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(AuthLoginRequest $request): LoginResource | JsonResponse
    {
        try {
            return LoginResource::make($this->userService->login($request->validated(), $request->user()));
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => $th->getCode(),
                'error' => $th->getMessage(),
                'trace' => $th->getTrace(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function user(): UserResource | JsonResponse
    {
        try {
            return UserResource::make(Auth::user());
        } catch (\Throwable $th) {
            return response()->json([
                'error_code' => $th->getCode(),
                'error' => $th->getMessage(),
                'trace' => $th->getTrace(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
