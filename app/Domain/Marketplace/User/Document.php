<?php

namespace App\Domain\Marketplace\User;

class Document
{
    public function __construct(
        private string $value
    ) {
        $this->validate();
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
        $this->validate();
    }
    private function validate(): void
    {
        if (strlen($this->value) != 11 && strlen($this->value) != 14) {
            throw new \Exception("Document invalid.");
        }
    }

    public function itsAShopkeepersDocument(): bool
    {
        return strlen($this->value) == 14;
    }
}
