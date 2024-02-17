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
}
