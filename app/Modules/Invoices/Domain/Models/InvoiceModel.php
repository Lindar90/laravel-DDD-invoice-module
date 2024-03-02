<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use App\Domain\Models\CompanyModel;
use Ramsey\Uuid\UuidInterface;

readonly class InvoiceModel
{
    public function __construct(
        private UuidInterface $id,
        private string $number,
        private string $date,
        private string $dueDate,
        private StatusEnum $status,
        private string $updatedAt,
        private CompanyModel $billToCompany,
        private CompanyModel $shipToCompany,
        /** @var InvoiceProductLineModel[] */
        private array $productLines,
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
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

    public function getBillToCompany(): CompanyModel
    {
        return $this->billToCompany;
    }

    public function getShipToCompany(): CompanyModel
    {
        return $this->shipToCompany;
    }

    /** @return InvoiceProductLineModel[] */
    public function getProductLines(): array
    {
        return $this->productLines;
    }

    public function getTotalPrice(): int
    {
        return array_reduce(
            $this->productLines,
            fn (int $total, InvoiceProductLineModel $productLine) => $total + $productLine->getTotal(),
            0
        );
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
