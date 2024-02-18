<?php

namespace App\Repositories\Account;

use App\Models\Account;
use App\Models\User;
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
     * @return Collection
     */
    public function getAllAccountsByUser(): Collection
    {
        return User::with('accounts')->get();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserAccounts(int $userId): Collection
    {
        return Account::where('user_id', $userId)->get();
    }

    /**
     * @param int $accountId
     * @param float $amount
     * @return Account
     */
    public function insertAccountBalance(int $accountId, float $amount): Account
    {
        $account = Account::find($accountId);
        $account->balance += $amount;
        $account->save();

        return $account;
    }

    /**
     * @param int $accountId
     * @return Account
     */
    public function getUserAccountById(int $accountId): Account
    {
        return Account::findOrFail($accountId);
    }


}
