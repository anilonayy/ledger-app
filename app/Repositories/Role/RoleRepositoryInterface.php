<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{
    /**
     * @param array $payload
     * @return void
     */
    public function store(array $payload): void;


    /**
     * @param int|User $user
     * @param int|Role $role
     * @return void
     */
    public function assignRole(int|User $user, int|Role $role): void;

    /**
     * @param int $userId
     * @return array
     */
    public function getAbilitiesByUser(int $userId): array;

    /**
     * @param string $roleName
     * @return Role
     */
    public function getRoleByName(string $roleName): Role;
}
