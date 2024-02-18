<?php

namespace App\Services\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;

interface TransactionServiceInterface
{
    /**
     * @param array $data
     * @return JsonResource
     */
    public function giveCredit(array $data): JsonResource;
}
