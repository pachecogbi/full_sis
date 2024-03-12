<?php

namespace App\Http\Repositories\Auth;

use App\Models\User;

interface UserInterface
{
    public function create(array $data): User;
}
