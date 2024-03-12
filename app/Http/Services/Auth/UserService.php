<?php

use App\Http\Repositories\Auth\UserRepository;
use App\Models\User;

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
}
