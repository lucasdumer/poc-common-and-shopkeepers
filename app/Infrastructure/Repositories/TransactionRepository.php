<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Marketplace\ITransactionRepository;
use App\Domain\Marketplace\Transaction;
use App\Infrastructure\Models\TransactionModel;
use Illuminate\Support\Facades\DB;

class TransactionRepository implements ITransactionRepository
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function create(Transaction $transaction): Transaction
    {
        try {
            DB::beginTransaction();
            $this->userRepository->update($transaction->getPayer());
            $this->userRepository->update($transaction->getPayee());
            $transactionModel = new TransactionModel();
            $transactionModel->payer_id = $transaction->getPayer()->getId();
            $transactionModel->payee_id = $transaction->getPayee()->getId();
            $transactionModel->value = $transaction->getValue();
            $transactionModel->save();
            DB::commit();
            $transaction->setId($transactionModel->id);
            return $transaction;
        } catch(\Exception $e) {
            DB::rollBack();
            throw new \Exception("Database error on create transaction. ".$e->getMessage());
        }
    }

    public function list(int $payerId = null, int $payeeId = null): array
    {
        $table = DB::table('transactions');
        if (!empty($payerId)) {
            $table->where('payer_id', '=', $payerId);
        }
        if (!empty($payeeId)) {
            $table->where('payee_id', '=', $payeeId);
        }
        return $this->toArray($table->get()->toArray());
    }

    private function toArray(array $transactions): array
    {
        return array_map(function ($transactionModel) {
            return [
                'id' => $transactionModel->id,
                'payer_id' => $transactionModel->payer_id,
                'payee_id' => $transactionModel->payee_id,
                'value' => $transactionModel->value
            ];
        }, $transactions);
    }
}
