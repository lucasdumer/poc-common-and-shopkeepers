<?php

namespace App\Application\Commands;

use App\Domain\Marketplace\ITransactionCreateCommand;

class TransactionCreateCommand implements ITransactionCreateCommand
{
    public function __construct(
        private int $payerId,
        private int $payeeId,
        private float $value
    ) {}

    public function getPayerId(): int
    {
        return $this->payerId;
    }

    public function getPayeeId(): int
    {
        return $this->payeeId;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
