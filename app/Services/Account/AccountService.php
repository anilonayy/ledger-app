<?php

namespace App\Services\Account;

use App\Http\Resources\Account\AccountResource;
use App\Http\Resources\Account\AccountWithUserResource;
use App\Http\Resources\Account\BalanceAtTimeResource;
use App\Models\Account;
use App\Models\User;
use App\Repositories\Account\AccountRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AccountService implements AccountServiceInterface
{

    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository
    ){}

    /**
     * @param array $data
     * @return JsonResource
     */
    public function store(array $data): JsonResource
    {
        $data['user_id'] = Auth::id();

        return AccountResource::make($this->accountRepository->create($data));
    }

    /**
     * @return JsonResource
     */
    public function getAllAccountsByUser(): JsonResource
    {
        return AccountWithUserResource::collection($this->accountRepository->getAllAccountsByUser());
    }

    /**
     * @param int $userId
     * @return JsonResource
     * @throws NotFoundHttpException
     */
    public function getUserAccounts(int $userId): JsonResource
    {
        if (!User::find($userId)) {
            throw new NotFoundHttpException("User not found with {$userId} id.");
        }

        return AccountResource::collection($this->accountRepository->getUserAccounts($userId));
    }

    /**
     * @param array $payload
     * @return JsonResource
     */
    public function getBalanceAtTime(array $payload): JsonResource
    {
        return BalanceAtTimeResource::make($this->accountRepository->getBalanceAtTime($payload))->additional([
            'date' => $payload['date'],
            'isSingle' => isset($payload['account_id'])
        ]);
    }

    /**
     * @return JsonResource
     */
    public function getMyAccounts(): JsonResource
    {
        return AccountResource::collection($this->accountRepository->getUserAccounts(Auth::id()));
    }
}
