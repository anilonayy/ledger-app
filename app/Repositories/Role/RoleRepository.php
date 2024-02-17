<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;

class RoleRepository implements RoleRepositoryInterface
{

    /**
     * @param array $payload
     * @return void
     */
    public function store(array $payload): void
    {
        Role::create($payload);
    }

    /**
     * @param int|User $user
     * @param int|Role $role
     * @return void
     */
    public function assignRole(int|User $user, int|Role $role): void
    {
        $userId = $user instanceof User ? $user->id : $user;
        $roleId = $role instanceof Role ? $role->id : $role;

        UserRole::create([
            'user_id' => $userId,
            'role_id' => $roleId
        ]);
    }
}
