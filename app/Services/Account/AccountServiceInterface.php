<?php

namespace App\Services\Account;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface AccountServiceInterface
{
    /**
     * @param array $data
     * @return JsonResource
     */
    public function store(array $data): JsonResource;

    /**
     * @return JsonResource
     */
    public function getAllAccountsByUser(): JsonResource;

    /**
     * @param int $userId
     * @return JsonResource
     * @throws NotFoundHttpException
     */
    public function getUserAccounts(int $userId): JsonResource;
}
