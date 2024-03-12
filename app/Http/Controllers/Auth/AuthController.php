<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use UserService;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    )
    {
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
}
