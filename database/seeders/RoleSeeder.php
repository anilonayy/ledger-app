<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class RoleSeeder extends Seeder
{

    public function __construct(private readonly RoleRepositoryInterface $roleRepository) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->roleRepository->store([
            'name' => 'admin'
        ]);

        $this->roleRepository->store([
            'name' => 'user'
        ]);
    }
}
