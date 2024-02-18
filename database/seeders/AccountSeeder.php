<?php

namespace Database\Seeders;

use App\Repositories\Account\AccountRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{

    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly UserRepositoryInterface $userRepository
    ) {}
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $root = $this->userRepository->getUserByEmail('root@useinsider.com');
        $admin = $this->userRepository->getUserByEmail('anil@useinsider.com');

        $this->accountRepository->create([
            'user_id' => $root->id,
            'name' => 'Root Cash',
            'currency' => 'USD',
        ]);

        $this->accountRepository->create([
            'user_id' => $admin->id,
            'name' => 'Cash',
            'currency' => 'USD',
        ]);

        $this->accountRepository->create([
            'user_id' => $admin->id,
            'name' => 'Gold Savings Account',
            'currency' => 'XAU',
        ]);
    }
}
