<?php

namespace App\Services\Transaction\Transaction;

use Illuminate\Http\Resources\Json\JsonResource;

interface TransactionServiceInterface
{
    /**
     * @param array $data
     * @return JsonResource
     */
    public function giveCredit(array $data): JsonResource;

    /**
     * @param array $data
     * @return JsonResource
     */
    public function transferBetweenAccounts(array $data): JsonResource;
}
