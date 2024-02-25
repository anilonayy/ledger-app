<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\Shared\AllWithFilterRequest;
use App\Http\Requests\Transactions\GiveCreditRequest;
use App\Http\Requests\Transactions\TransferRequest;
use App\Http\Requests\Transactions\WithdrawRequest;
use App\Services\Transaction\Transaction\TransactionService;
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

    /**
     * @param TransferRequest $request
     * @param TransactionService $transactionService
     * @return JsonResponse
     * @throws \Exception
     */
    public function transferBetweenAccounts(TransferRequest $request, TransactionService $transactionService): JsonResponse
    {
        return Api::ok($transactionService->transferBetweenAccounts($request->validated()));
    }

    /**
     * @param WithdrawRequest $request
     * @param TransactionService $transactionService
     * @return JsonResponse
     */
    public function withdraw(WithdrawRequest $request, TransactionService $transactionService): JsonResponse
    {
        return Api::ok($transactionService->withdraw($request->validated()));
    }

    /**
     * @param AllWithFilterRequest $request
     * @param int $accountId
     * @param TransactionService $transactionService
     * @return JsonResponse
     */
    public function getMyTransactions(
        int $accountId,
        AllWithFilterRequest $request,
        TransactionService $transactionService
    ): JsonResponse {
        return Api::ok($transactionService->getMyTransactions($request->validated(), $accountId));
    }

    /**
     * @param int $transactionId
     * @param TransactionService $transactionService
     * @return JsonResponse
     */
    public function getSingleTransaction(int $transactionId, TransactionService $transactionService): JsonResponse
    {
        return Api::ok($transactionService->getSingleTransaction($transactionId));
    }
}
