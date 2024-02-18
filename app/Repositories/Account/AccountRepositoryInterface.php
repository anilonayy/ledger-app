<?php

namespace App\Repositories\Account;


use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

interface AccountRepositoryInterface
{

    /**
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account;

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserAccounts(int $userId): Collection;

    /**
     * @param int $accountId
     * @return Account
     */
    public function getUserAccountById(int $accountId): Account;

    /**
     * @param int $accountId
     * @param float $amount
     * @return Account
     */
    public function insertAccountBalance(int $accountId, float $amount): Account;
}
