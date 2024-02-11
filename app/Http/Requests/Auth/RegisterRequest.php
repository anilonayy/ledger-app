<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'birthday' => 'sometimes|date',
            'device' => 'required|string',
        ];
    }
}
