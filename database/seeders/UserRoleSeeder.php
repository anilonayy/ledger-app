<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function __construct(private readonly RoleRepositoryInterface $roleRepository){}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'anil@useinsider.com')->first();
        $adminRole = Role::where('name', 'admin')->first();

        $this->roleRepository->assignRole($user,  $adminRole);
    }
}
