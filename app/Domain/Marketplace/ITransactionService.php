<?php

namespace App\Domain\Marketplace;

interface ITransactionService
{
    public function create(ITransactionCreateCommand $transactionCreateCommand): Transaction;
    public function list(int $payerId = null, int $payeeId = null): array;
}
