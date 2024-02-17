<?php

namespace App\Repositories\Role;

interface RoleRepositoryInterface
{
    /**
     * @param array $payload
     * @return void
     */
    public function store(array $payload): void;


    /**
     * @param int $userId
     * @param int $roleId
     * @return void
     */
    public function assignRole(int $userId, int $roleId): void;
}
