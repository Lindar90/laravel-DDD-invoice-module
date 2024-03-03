<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Application\InvoiceFacade;

use App\Modules\Invoices\API\DTO\InvoiceDetailsRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;

class InvoiceFacadeGetDetailsTest extends AbstractInvoiceFacadeTest
{
    public function testGetDetails(): void
    {
        $dto = new InvoiceDetailsRequestDTO('123');
        $invoiceModel = $this->createInvoiceModel();

        $this->invoiceRepository
            ->expects($this->once())
            ->method('getDetails')
            ->with('123')
            ->willReturn($invoiceModel);

        $result = $this->invoiceFacade->getDetails($dto);

        $this->assertInstanceOf(InvoiceDetailsResponseDTO::class, $result);
        $this->assertEquals($result->toArray(), $this->createInvoiceDetailsResponseDTOToArrayResult($invoiceModel));
    }

    public function testGetDetailsNotFound(): void
    {
        $dto = new InvoiceDetailsRequestDTO('123');
        $this->invoiceRepository
            ->expects($this->once())
            ->method('getDetails')
            ->with('123')
            ->willThrowException(new InvoiceNotFoundException('123'));

        $this->expectException(InvoiceNotFoundException::class);
        $this->invoiceFacade->getDetails($dto);
    }

    /**
     * @return mixed[]
     */
    private function createInvoiceDetailsResponseDTOToArrayResult($invoiceModel): array
    {
        return [
            'number' => $invoiceModel->getNumber(),
            'date' => $invoiceModel->getDate(),
            'dueDate' => $invoiceModel->getDueDate(),
            'totalPrice' => $invoiceModel->getTotalPrice(),
            'billToCompany' => [
                'name' => $invoiceModel->getBillToCompany()->getName(),
                'address' => $invoiceModel->getBillToCompany()->getStreetAddress(),
                'city' => $invoiceModel->getBillToCompany()->getCity(),
                'zipCode' => $invoiceModel->getBillToCompany()->getZip(),
                'phone' => $invoiceModel->getBillToCompany()->getPhone(),
                'email' => $invoiceModel->getShipToCompany()->getEmail(),
            ],
            'shipToCompany' => [
                'name' => $invoiceModel->getShipToCompany()->getName(),
                'address' => $invoiceModel->getShipToCompany()->getStreetAddress(),
                'city' => $invoiceModel->getShipToCompany()->getCity(),
                'zipCode' => $invoiceModel->getShipToCompany()->getZip(),
                'phone' => $invoiceModel->getShipToCompany()->getPhone(),
            ],
            'productLines' => [],
        ];
    }
}
