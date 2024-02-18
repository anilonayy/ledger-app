<?php

namespace App\Services\Transaction\Transaction;

use App\Enums\TransactionStatusEnums;
use App\Enums\TransactionTypeEnums;
use App\Helpers\CurrencyHelper;
use App\Http\Resources\Account\AccountResource;
use App\Models\Account;
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
        $senderAccount = $this->accountRepository->getUserAccounts(
            $this->userRepository->getUserByEmail('root@useinsider.com')->id
        )->first();

        $data['sender_account_id'] = $senderAccount->id;

        return AccountResource::make(
            $this->createTransaction($data, TransactionTypeEnums::CREDIT, TransactionStatusEnums::SUCCESS)
        );
    }

    /**
     * @param array $data
     * @return JsonResource
     * @throws Exception
     */
    public function transferBetweenAccounts(array $data): JsonResource
    {
        return AccountResource::make(
            $this->createTransaction($data, TransactionTypeEnums::TRANSFER, TransactionStatusEnums::SUCCESS)
        );
    }

    /**
     * @param array $data
     * @return JsonResource
     * @throws Exception
     */
    public function withdraw(array $data): JsonResource
    {
        $payload = [
            'sender_account_id' => $data['account_id'],
            'receiver_account_id' => $data['account_id'],
            'amount' => -$data['amount'],
            'type' => TransactionTypeEnums::WITHDRAW,
            'status' => TransactionStatusEnums::SUCCESS,
            'creator_id' => Auth::id(),
            'note' => $data['note'] ?? "Withdraw from account"
        ];

        return AccountResource::make($this->createSingleTransaction($payload));
    }

    /**
     * @param array $data
     * @param TransactionTypeEnums $type
     * @param TransactionStatusEnums $status
     * @return Account
     * @throws Exception
     */
    protected function createTransaction(array $data, TransactionTypeEnums $type, TransactionStatusEnums $status): Account
    {
        try {
            DB::beginTransaction();

            $senderAccount = $this->accountRepository->getAccountByIdWithUser($data['sender_account_id']);
            $receiverAccount = $this->accountRepository->getAccountByIdWithUser($data['receiver_account_id']);

            $convertedAmount = $data['amount'];

            $receiverNote = $data['note'] ?? "Transfer from {$senderAccount->user->name}";
            $senderNote = $data['note'] ?? "Transfer to {$receiverAccount->user->name}";

            if ($senderAccount->currency !== $receiverAccount->currency) {
                $convertedData = CurrencyHelper::convert($data['amount'], $senderAccount->currency, $receiverAccount->currency);

                $convertedAmount = $convertedData['amount'];
                $receiverNote = "{$data['amount']} {$senderAccount->currency} converted to {$convertedAmount} {$receiverAccount->currency} with rate {$convertedData['rate']}.";
            }

            $this->transactionRepository->create([
                'sender_account_id' => $senderAccount->id,
                'receiver_account_id' => $receiverAccount->id,
                'amount' => $convertedAmount,
                'type' => $type,
                'status' => $status,
                'creator_id' => Auth::id(),
                'description' => $receiverNote
            ]);

            $this->transactionRepository->create([
                'sender_account_id' => $receiverAccount->id,
                'receiver_account_id' => $senderAccount->id,
                'amount' => -$data['amount'],
                'type' => $type,
                'status' => $status,
                'creator_id' => Auth::id(),
                'description' =>  $senderNote
            ]);

            $this->accountRepository->insertAccountBalance($receiverAccount->id, $convertedAmount);
            $senderAccount = $this->accountRepository->insertAccountBalance($senderAccount->id, -$data['amount']);

            DB::commit();

            return $senderAccount;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param array $payload
     * @return Account
     * @throws Exception
     */
    private function createSingleTransaction(array $payload): Account
    {
        try {
            DB::beginTransaction();

            $senderAccount = $this->accountRepository->getAccountByIdWithUser($payload['sender_account_id']);
            $receiverAccount = $this->accountRepository->getAccountByIdWithUser($payload['receiver_account_id']);

            $convertedAmount = $payload['amount'];

            $note = $payload['note'] ?? "Transfer from {$senderAccount->user->name}";

            if ($senderAccount->currency !== $receiverAccount->currency) {
                $convertedData = CurrencyHelper::convert($payload['amount'], $senderAccount->currency, $receiverAccount->currency);

                $convertedAmount = $convertedData['amount'];
                $note = "{$payload['amount']} {$senderAccount->currency} converted to {$convertedAmount} {$receiverAccount->currency} with rate {$convertedData['rate']}.";
            }

            $this->transactionRepository->create([
                'sender_account_id' => $receiverAccount->id,
                'receiver_account_id' => $senderAccount->id,
                'amount' => $convertedAmount,
                'type' => $payload['type'],
                'status' => $payload['status'],
                'creator_id' => $payload['creator_id'],
                'description' =>  $note
            ]);

            $senderAccount = $this->accountRepository->insertAccountBalance($senderAccount->id, $convertedAmount);

            DB::commit();

            return $senderAccount;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }
}
