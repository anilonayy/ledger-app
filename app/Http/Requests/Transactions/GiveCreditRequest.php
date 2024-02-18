<?php

namespace App\Http\Requests\Transactions;

use App\Http\Requests\Request;

class GiveCreditRequest extends Request
{
    public function rules(): array
    {
        return [
            'receiver_account_id' => 'required|integer|exists:accounts,id',
            'amount' => 'required|numeric|min:0'
        ];
    }
}
