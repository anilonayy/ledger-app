<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransactionRepositoryInterface
{
    /**
     * @param array $data
     * @return Transaction
     */
    public function create(array $data): Transaction;

    /**
     * @param array $payload
     * @param int $accountId
     * @return LengthAwarePaginator
     */
    public function getTransactionsByAccount(array $payload, int $accountId): LengthAwarePaginator;

    /**
     * @param int $id
     * @return Transaction
     */
    public function getByIdWithDetails(int $id): Transaction;
}
