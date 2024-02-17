<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    /**
     * @param object $payload
     * @return User
     */
    public function create(object $payload): User
    {
        return User::create([
            'name' => $payload->name,
            'email' => $payload->email,
            'password' => Hash::make($payload->password)
        ]);
    }

    public function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }
}
