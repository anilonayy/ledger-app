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

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    /**
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User
    {
        return User::findOrFail($id);
    }
}
