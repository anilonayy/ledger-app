<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Repositories\Role\RoleRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(private readonly RoleRepositoryInterface $roleRepository) {}

    /**
     * @param User $user
     * @param string $device
     * @return string
     */
    public function getToken(User $user, string $device): string
    {
        $abilities = $this->roleRepository->getAbilitiesByUser($user->id);

        return $user->createToken($device, $abilities)->plainTextToken;
    }
}
