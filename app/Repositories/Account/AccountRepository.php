<?php

namespace App\Repositories\Account;

use App\Enums\TransactionStatusEnums;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountRepository implements AccountRepositoryInterface
{

    /**
     * @param array $data
     * @return Account
     */
    public function create(array $data): Account
    {
        return Account::create([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'currency' => $data['currency'],
            'balance' => 0,
        ]);
    }

    /**
     * @return Collection
     */
    public function getAllAccountsByUser(): Collection
    {
        return User::with('accounts')->get();
    }

    /**
     * @param int $userId
     * @return Collection
     */
    public function getUserAccounts(int $userId): Collection
    {
        return Account::where('user_id', $userId)->get();
    }

    /**
     * @param int $accountId
     * @param float $amount
     * @return Account
     */
    public function insertAccountBalance(int $accountId, float $amount): Account
    {
        $account = Account::find($accountId);
        $account->balance += $amount;
        $account->save();

        return $account;
    }

    /**
     * @param int $accountId
     * @return Account
     */
    public function getAccountById(int $accountId): Account
    {
        return Account::findOrFail($accountId);
    }


    /**
     * @param int $accountId
     * @return Account
     */
    public function getAccountByIdWithUser(int $accountId): Account
    {
        return Account::with('user')->findOrFail($accountId);
    }

    /**
     * @param array $payload
     * @return Collection
     */
    public function getBalanceAtTime(array $payload): Collection
    {
        $date = Carbon::parse($payload['date'])->timezone('UTC')->toDateTimeString();

        return Account::where('user_id', Auth::id())
            ->when(isset($payload['account_id']), function ($query) use ($payload) {
                $query->where('id', $payload['account_id']);
            })
            ->select('id','name', 'balance', 'currency')
            ->addSelect([
                'balance_at_time' => Transaction::select(DB::raw('SUM(amount)'))
                    ->whereColumn('receiver_account_id', 'accounts.id')
                    ->where('status', TransactionStatusEnums::SUCCESS)
                    ->where('created_at', '<=', $date)
            ])
            ->get();
    }
}
