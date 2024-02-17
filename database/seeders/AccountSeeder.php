<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use App\Repositories\Account\AccountRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $admin = $this->userRepository->getUserByEmail('anil@useinsider.com');

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
