<?php

namespace Database\Seeders;

use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{

    public function __construct(private readonly RoleRepositoryInterface $roleRepository) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->roleRepository->store([
            'name' => 'admin',
            'abilities' => '*'
        ]);

        $this->roleRepository->store([
            'name' => 'user',
            'abilities' => [
                'accounts.create',
                'accounts.balance-at-time',
                'accounts.read-own',
                'transactions.transfer',
                'transactions.withdraw',
            ]
        ]);
    }
}
