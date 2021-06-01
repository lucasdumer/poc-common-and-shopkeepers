<?php

namespace App\Domain\Marketplace;

interface ITransactionRepository
{
    public function create(Transaction $transaction): Transaction;
    public function list(int $payerId = null, int $payeeId = null): array;
}
