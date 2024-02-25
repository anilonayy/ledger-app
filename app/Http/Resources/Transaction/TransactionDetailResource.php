<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'amount' => $this->amount,
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'sender_account' => [
                'id' => $this->sender->id,
                'user' => [
                    'id' => $this->sender->user->id,
                    'name' => $this->sender->user->name,
                ],
                'name' => $this->sender->name,
                'currency' => $this->sender->currency,
            ],
            'receiver_account' => [
                'id' => $this->receiver->id,
                'currency' => $this->receiver->currency,
                'balance' => $this->receiver->balance,
            ],
        ];
    }
}
