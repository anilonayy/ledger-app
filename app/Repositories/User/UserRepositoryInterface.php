<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param object $payload
     * @return User
     */
    public function create(object $payload): User;

    /**
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User;

    /**
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User;
}
