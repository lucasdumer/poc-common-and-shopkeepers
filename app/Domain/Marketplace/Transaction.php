<?php

namespace App\Domain\Marketplace;

use App\Domain\Marketplace\User\User;

class Transaction
{
    public function __construct(
        private User $payer,
        private User $payee,
        private float $value
    ) {
        $this->validate();
    }

    public function getPayer(): User
    {
        return $this->payer;
    }

    public function getPayee(): User
    {
        return $this->payee;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    private function validate()
    {
        if ($this->payer->getId() == $this->payee->getId()) {
            throw new \Exception("It is not possible to transition to the same person.");
        }

        if ($this->payer->isAShopkeeper()) {
            throw new \Exception("Shopkeeper doesn't pay.");
        }

        if ($this->value <= 0) {
            throw new \Exception("It is not possible to do a zeroed transaction.");
        }
    }
}
