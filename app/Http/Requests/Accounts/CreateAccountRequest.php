<?php

namespace App\Http\Requests\Accounts;

use App\Http\Requests\Request;
use App\Repositories\Account\AccountRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CreateAccountRequest extends Request
{

    public function __construct(private readonly AccountRepositoryInterface $accountRepository)
    {
        parent::__construct();
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:55',
            'currency' => 'required|string|min:3|max:3',
        ];
    }

    /**
     * @param $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $name = $this->input('name');

            $isExits =  $this->accountRepository->getUserAccounts(Auth::id())->some(function ($account) use ($name) {
                return $account['name'] === $name;
            });

            if($isExits){
                $validator->errors()->add('name', 'Account with this name already exists');
            }
        });
    }
}


