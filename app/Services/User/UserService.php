<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{

    /**
     * @param object $payload
     * @return array
     */
    public function store(object $payload): array
    {
        $user = User::create([
            'name' => $payload->name,
            'email' => $payload->email,
            'password' => Hash::make($payload->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }
}
