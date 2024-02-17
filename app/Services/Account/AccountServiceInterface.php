<?php

namespace App\Services\Account;

use Illuminate\Http\Resources\Json\JsonResource;

interface AccountServiceInterface
{
    /**
     * @param array $data
     * @return JsonResource
     */
    public function store(array $data): JsonResource;
}
