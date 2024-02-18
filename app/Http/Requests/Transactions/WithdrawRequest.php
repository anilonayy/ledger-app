<?php

namespace App\Http\Requests\Transactions;

use App\Http\Requests\Request;
use App\Repositories\Account\AccountRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class WithdrawRequest extends Request
{
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository
    )
    {
        parent::__construct();
    }
    public function rules(): array
    {
        return [
            'account_id' => 'required|integer|exists:accounts,id',
            'amount' => 'required|numeric|gt:0',
        ];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $senderAccount = $this->accountRepository->getAccountById($this->input('account_id'));

            if ($senderAccount->balance < $this->input('amount')) {
                $validator->errors()->add('amount', 'Insufficient balance');
            }

            if($senderAccount->user_id !== Auth::id()) {
                $validator->errors()->add('account_id', 'You only can transfer from your account.');
            }
        });
    }
}
