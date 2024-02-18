<?php

namespace App\Http\Resources\Account;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceAtTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $accountResource = $this->additional['isSingle']
            ? BalanceAtTimeAccountResource::make($this->resource->first())
            : BalanceAtTimeAccountResource::collection($this->resource);

        $returnArray = [
            'date' => $this->additional['date'],
        ];

        $returnArray[$this->additional['isSingle'] ? 'account' : 'accounts'] = $accountResource;

        return $returnArray;
    }
}
