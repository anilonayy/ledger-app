<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Collection;

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

    /**
     * @param int $userId
     * @return Collection
     */
    public function getRolesByUserId(int $userId): Collection
    {
        return User::where('id', $userId)->with('roles')->firstOrFail()->roles
            ->map((fn($userRole) => $userRole->role));
    }

    /**
     * @param string $roleName
     * @return Role
     */
    public function getRoleByName(string $roleName): Role
    {
        return Role::where('name', $roleName)->firstOrFail();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getAbilitiesByUser(int $userId): array
    {
        return $this->getRolesByUserId($userId)->map(fn($role) => $role->abilities)->flatten()->toArray();
    }
}
