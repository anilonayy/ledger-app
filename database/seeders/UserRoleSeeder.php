<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly RoleRepositoryInterface $roleRepository
    ){}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = $this->userRepository->getUserByEmail('anil@useinsider.com');
        $adminRole =  $this->roleRepository->getRoleByName('admin');

        $this->roleRepository->assignRole($user,  $adminRole);

        $this->command->info( "{$adminRole->name} role assigned to {$user->name}");
    }
}
