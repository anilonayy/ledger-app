<?php

namespace App\Repositories\Account;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class AccountRepository implements AccountRepositoryInterface
{

    /**
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account
    {
        return Account::create([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'currency' => $data['currency'],
            'balance' => 0,
        ]);
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserAccounts(int $userId): Collection
    {
        return Account::where('user_id', $userId)->get();
    }
}
