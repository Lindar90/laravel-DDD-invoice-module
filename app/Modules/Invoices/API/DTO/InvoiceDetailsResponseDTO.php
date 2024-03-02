<?php

declare(strict_types=1);

namespace App\Modules\Invoices\API\DTO;

use App\API\DTO\AbstractDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO\BillToCompanyDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO\InvoiceProductLineDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO\ShipToCompanyDTO;

class InvoiceDetailsResponseDTO extends AbstractDTO
{
    public function __construct(
        private readonly string $number,
        private readonly string $date,
        private readonly string $dueDate,
        private readonly int $totalPrice,
        private readonly BillToCompanyDTO $billToCompany,
        private readonly ShipToCompanyDTO $shipToCompany,
        /** @var InvoiceProductLineDTO[] */
        private readonly array $productLines,
    ) {
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    public function getBillToCompany(): BillToCompanyDTO
    {
        return $this->billToCompany;
    }

    public function getShipToCompany(): ShipToCompanyDTO
    {
        return $this->shipToCompany;
    }

    /**
     * @return InvoiceProductLineDTO[]
     */
    public function getProductLines(): array
    {
        return $this->productLines;
    }
}
