<?php

namespace App\Http\Repositories\Auth;

use App\Models\User;

class UserRepository implements UserInterface
{
    public function __construct(private readonly User $model)
    {
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }
}
