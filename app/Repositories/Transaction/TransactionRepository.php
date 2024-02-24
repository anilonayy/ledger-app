<?php

namespace App\Repositories\Transaction;

use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;

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

    /**
     * @param array $payload
     * @param int $accountId
     * @return LengthAwarePaginator
     */
    public function getTransactionsByAccount(array $payload, int $accountId): LengthAwarePaginator
    {
        $sort = $payload['sort'] ?? 'created_at';
        $order = $payload['order'] ?? 'desc';
        $take = $payload['take'] ?? 10;
        $page = $payload['page'] ?? 1;

        return Transaction::where('receiver_account_id', $accountId)
            ->orderBy($sort, $order)
            ->select('id', 'amount', 'type', 'status', 'description', 'created_at')
            ->skip($take * ($page - 1))
            ->take($take)
            ->paginate($take, ['*'], 'page');
    }
}
