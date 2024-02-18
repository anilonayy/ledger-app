<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{

    /**
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }
}
