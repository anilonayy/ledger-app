<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\Transactions\GiveCreditRequest;
use App\Services\Transaction\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * @param GiveCreditRequest $request
     * @param TransactionService $transactionService
     * @return JsonResponse
     * @throws \Exception
     */
    public function giveCredit(GiveCreditRequest $request, TransactionService $transactionService): JsonResponse
    {
        return Api::created($transactionService->giveCredit($request->validated()));
    }
}
