<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mappers;

use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO\BillToCompanyDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO\InvoiceProductLineDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO\ShipToCompanyDTO;
use App\Modules\Invoices\Domain\Models\InvoiceModel;
use App\Modules\Invoices\Domain\Models\InvoiceProductLineModel;

class InvoiceModelToResponseDTOMapper
{
    public static function map(InvoiceModel $invoiceModel): InvoiceDetailsResponseDTO
    {
        $productLines = array_map(
            fn (InvoiceProductLineModel $productLine) => new InvoiceProductLineDTO(
                name: $productLine->getName(),
                quantity: $productLine->getQuantity(),
                unitPrice: $productLine->getUnitPrice(),
                total: $productLine->getTotal(),
            ),
            $invoiceModel->getProductLines()
        );

        $billToCompanyDTO = new BillToCompanyDTO(
            name: $invoiceModel->getBillToCompany()->getName(),
            address: $invoiceModel->getBillToCompany()->getStreetAddress(),
            city: $invoiceModel->getBillToCompany()->getCity(),
            zipCode: $invoiceModel->getBillToCompany()->getZip(),
            phone: $invoiceModel->getBillToCompany()->getPhone(),
            email: $invoiceModel->getBillToCompany()->getEmail(),
        );

        $shipToCompanyDTO = new ShipToCompanyDTO(
            name: $invoiceModel->getShipToCompany()->getName(),
            address: $invoiceModel->getShipToCompany()->getStreetAddress(),
            city: $invoiceModel->getShipToCompany()->getCity(),
            zipCode: $invoiceModel->getShipToCompany()->getZip(),
            phone: $invoiceModel->getShipToCompany()->getPhone(),
        );

        return new InvoiceDetailsResponseDTO(
            number: $invoiceModel->getNumber(),
            date: $invoiceModel->getDate(),
            dueDate: $invoiceModel->getDueDate(),
            totalPrice: $invoiceModel->getTotalPrice(),
            billToCompany: $billToCompanyDTO,
            shipToCompany: $shipToCompanyDTO,
            productLines: $productLines,
        );
    }
}
