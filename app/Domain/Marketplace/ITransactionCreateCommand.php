<?php

namespace App\Domain\Marketplace;

interface ITransactionCreateCommand
{
    public function getPayerId(): int;
    public function getPayeeId(): int;
    public function getValue(): float;
}
