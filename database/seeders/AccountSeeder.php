<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use App\Repositories\Account\AccountRepositoryInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{

    public function __construct(private readonly AccountRepositoryInterface $accountRepository) {}
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'anil@useinsider.com')->first();

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
