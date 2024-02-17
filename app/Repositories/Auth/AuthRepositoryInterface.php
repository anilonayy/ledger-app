<?php

namespace App\Repositories\Auth;

use App\Models\User;

interface AuthRepositoryInterface
{
    /**
     * @param User $user
     * @param string $device
     * @return string
     */
    public function getToken(User $user, string $device): string;
}
