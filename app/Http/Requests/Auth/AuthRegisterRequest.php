<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'password'   => ['required', 'string'],
            'c_password' => ['required', 'same:password'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'name'     => [
                'description' => 'New user name',
                'example'     => 'Jhon Smith'
            ],
            'email'    => [
                'description' => 'New user email',
                'example'     => 'jhon@gmail.com'
            ],
            'password' => [
                'description' => 'Password for registration',
                'example'     => 'thisisapassword123'
            ],
            'c_password' => [
                'description' => 'Password confirmation',
                'example'     => 'thisisapassword123'
            ],
        ];
    }
}
