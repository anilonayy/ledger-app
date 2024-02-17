<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\Accounts\CreateAccountRequest;
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
        return Api::ok($accountService->store($request->validated()));
    }
}
