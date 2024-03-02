<?php

declare(strict_types=1);

namespace App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO;

use App\API\DTO\AbstractDTO;

class InvoiceProductLineDTO extends AbstractDTO
{
    public function __construct(
        private string $name,
        private int $quantity,
        private int $unitPrice,
        private int $total,
    ) {
    }

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
        return $this->total;
    }
}
