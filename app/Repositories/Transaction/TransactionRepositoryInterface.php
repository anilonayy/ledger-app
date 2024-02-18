<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;

interface TransactionRepositoryInterface
{
    /**
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction;
}
