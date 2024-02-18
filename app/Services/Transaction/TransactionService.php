<?php

namespace App\Services\Transaction;

use App\Enums\TransactionStatusEnums;
use App\Enums\TransactionTypeEnums;
use App\Helpers\CurrencyHelper;
use App\Http\Resources\Account\AccountResource;
use App\Http\Resources\Transactions\GiveCreditResource;
use App\Repositories\Account\AccountRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionService implements TransactionServiceInterface
{
    public function __construct(
        private readonly TransactionRepositoryInterface $transactionRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly AccountRepositoryInterface $accountRepository
    ){}


    /**
     * @param array $data
     * @return JsonResource
     * @throws Exception
     */
    public function giveCredit(array $data): JsonResource
    {
        try {
            DB::beginTransaction();

            $senderAccount = $this->accountRepository->getUserAccounts(
                $this->userRepository->getUserByEmail('root@useinsider.com')->id
            )->first();
            $receiverAccount = $this->accountRepository->getUserAccountById($data['receiver_account_id']);
            $convertedAmount = $data['amount'];

            $receiverNote = env('APP_NAME')." give credit to you. Happy Spending!";
            $senderNote = "You give credit to ".env('APP_NAME')." Thank you!";

            if ($senderAccount->currency !== $receiverAccount->currency) {
                $convertedData = CurrencyHelper::convert($data['amount'], $senderAccount->currency, $receiverAccount->currency);

                $convertedAmount = $convertedData['amount'];
                $receiverNote = "{$data['amount']} {$senderAccount->currency} converted to {$convertedAmount} {$receiverAccount->currency} with rate {$convertedData['rate']}.";
            }

            $this->transactionRepository->create([
                'sender_account_id' => $senderAccount->id,
                'receiver_account_id' => $receiverAccount->id,
                'amount' => $convertedAmount,
                'type' => TransactionTypeEnums::CREDIT,
                'status' => TransactionStatusEnums::SUCCESS,
                'creator_id' => Auth::id(),
                'description' => $receiverNote
            ]);

            $this->transactionRepository->create([
                'sender_account_id' => $receiverAccount->id,
                'receiver_account_id' => $senderAccount->id,
                'amount' => -$data['amount'],
                'type' => TransactionTypeEnums::CREDIT,
                'status' => TransactionStatusEnums::SUCCESS,
                'creator_id' => Auth::id(),
                'description' =>  $senderNote
            ]);

            $account = $this->accountRepository->insertAccountBalance($receiverAccount->id, $convertedAmount);
            $this->accountRepository->insertAccountBalance($senderAccount->id, -$data['amount']);

            DB::commit();

            return AccountResource::make($account);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
