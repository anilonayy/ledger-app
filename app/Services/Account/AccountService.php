<?php

namespace App\Services\Account;

use App\Http\Resources\Account\AccountCreatedResource;
use App\Repositories\Account\AccountRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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

        return AccountCreatedResource::make($this->accountRepository->create($data));
    }
}
