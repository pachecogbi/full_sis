<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'       => ['required', 'email', 'exists:users,email'],
            'password'    => ['required', 'string'],
            'remember_me' => ['nullable', 'boolean'],
        ];
    }

    public function queryParameters(): array
    {
        return [
            'email'    => [
                'description' => 'Email from registred user',
                'example'     => 'jhon@gmail.com'
            ],
            'password' => [
                'description' => 'Password from registred user',
                'example'     => 'thisisapassword123'
            ],
            'remember_me' => [
                'description' => 'Boolean check for remmember user credentials',
                'example'     => true
            ],
        ];
    }
}
