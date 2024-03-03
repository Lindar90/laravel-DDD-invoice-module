<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Application\InvoiceFacade;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\API\DTO\InvoiceRejectRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceRejectResponseDTO;
use App\Modules\Invoices\Domain\Exceptions\InvoiceCanNotBeRejectedException;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use LogicException;

class InvoiceFacadeRejectTest extends AbstractInvoiceFacadeTest
{
    public function testReject(): void
    {
        $dto = new InvoiceRejectRequestDTO('123');
        $invoiceModel = $this->createInvoiceModel();

        $this->approvalFacade
            ->expects($this->once())
            ->method('reject')
            ->willReturn(true);

        $this->invoiceRepository
            ->expects($this->once())
            ->method('getDetails')
            ->with('123')
            ->willReturn($invoiceModel);

        $rejectedInvoiceModel = $this->createInvoiceModel(StatusEnum::REJECTED);

        $this->invoiceRepository
            ->expects($this->once())
            ->method('reject')
            ->with('123')
            ->willReturn($rejectedInvoiceModel);

        $result = $this->invoiceFacade->reject($dto);

        $this->assertInstanceOf(InvoiceRejectResponseDTO::class, $result);
    }

    public function testRejectNotFound(): void
    {
        $dto = new InvoiceRejectRequestDTO('123');
        $this->invoiceRepository
            ->expects($this->once())
            ->method('getDetails')
            ->with('123')
            ->willThrowException(new InvoiceNotFoundException('123'));

        $this->expectException(InvoiceNotFoundException::class);
        $this->invoiceFacade->reject($dto);
    }

    public function testRejectAlreadyRejected(): void
    {
        $dto = new InvoiceRejectRequestDTO('123');
        $invoiceModel = $this->createInvoiceModel(StatusEnum::REJECTED);

        $this->invoiceRepository
            ->expects($this->once())
            ->method('getDetails')
            ->with('123')
            ->willReturn($invoiceModel);

        $this->approvalFacade
            ->expects($this->once())
            ->method('reject')
            ->willThrowException(new LogicException('approval status is already assigned'));


        $this->expectException(InvoiceCanNotBeRejectedException::class);
        $this->invoiceFacade->reject($dto);
    }
}
