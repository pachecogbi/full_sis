<?php

namespace App\Http\Services\Auth;

use App\Http\Repositories\Auth\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    public function create(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

        $user = $this->userRepository->create($data);

        $tokenResult = $user->createToken('Personal Acess Token');
        $user['token'] = $tokenResult->plainTextToken;

        return $user;
    }

    public function login(array $data): array
    {
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];

        abort_if(
            !Auth::attempt($credentials),
            'Unauthorized',
            Response::HTTP_UNAUTHORIZED
        );

        $user = $this->userRepository->getByEmail($credentials['email']);
        $tokenResult = $user->createToken('Personal Acess Token');

        return [
            'token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
        ];
    }
}
