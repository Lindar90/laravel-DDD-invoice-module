<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

class InvoiceProductLineModel
{

    public function __construct(
        private string $name,
        private int $quantity,
        private int $unitPrice,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    public function getTotal(): int
    {
        return $this->quantity * $this->unitPrice;
    }
}
