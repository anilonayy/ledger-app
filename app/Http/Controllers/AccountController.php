<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\Accounts\CreateAccountRequest;
use App\Http\Requests\Accounts\GetBalanceAtTimeRequest;
use App\Services\Account\AccountServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccountController extends Controller
{

    /**
     * @param CreateAccountRequest $request
     * @param AccountServiceInterface $accountService
     * @return JsonResponse
     */
    public function store(CreateAccountRequest $request, AccountServiceInterface $accountService): JsonResponse
    {
        return Api::created($accountService->store($request->validated()));
    }

    /**
     * @param AccountServiceInterface $accountService
     * @return JsonResponse
     */
    public function getAllUserAccounts(AccountServiceInterface $accountService): JsonResponse
    {
        return Api::ok($accountService->getAllAccountsByUser());
    }

    /**
     * @param int $userId
     * @param AccountServiceInterface $accountService
     * @return JsonResponse
     */
    public function getUserAccounts(int $userId, AccountServiceInterface $accountService): JsonResponse
    {
        return Api::ok($accountService->getUserAccounts($userId));
    }

    /**
     * @param GetBalanceAtTimeRequest $request
     * @param AccountServiceInterface $accountService
     * @return JsonResponse
     */
    public function getBalanceAtTime(GetBalanceAtTimeRequest $request, AccountServiceInterface $accountService): JsonResponse
    {
        return Api::ok($accountService->getBalanceAtTime($request->validated()));
    }

    /**
     * @param AccountServiceInterface $accountService
     * @return JsonResponse
     */
    public function getMyAccounts(AccountServiceInterface $accountService): JsonResponse
    {
        return Api::ok($accountService->getMyAccounts());
    }
}
