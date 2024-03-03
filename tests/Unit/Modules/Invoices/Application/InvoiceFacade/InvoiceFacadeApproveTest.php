<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Application\InvoiceFacade;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\API\DTO\InvoiceApproveRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceApproveResponseDTO;
use App\Modules\Invoices\Domain\Exceptions\InvoiceCanNotBeApprovedException;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use LogicException;

class InvoiceFacadeApproveTest extends AbstractInvoiceFacadeTest
{
    public function testApproval(): void
    {
        $dto = new InvoiceApproveRequestDTO('123');
        $invoiceModel = $this->createInvoiceModel();

        $this->approvalFacade
            ->expects($this->once())
            ->method('approve')
            ->willReturn(true);

        $this->invoiceRepository
            ->expects($this->once())
            ->method('getDetails')
            ->with('123')
            ->willReturn($invoiceModel);

        $approvedInvoiceModel = $this->createInvoiceModel(StatusEnum::APPROVED);

        $this->invoiceRepository
            ->expects($this->once())
            ->method('approve')
            ->with('123')
            ->willReturn($approvedInvoiceModel);

        $result = $this->invoiceFacade->approve($dto);

        $this->assertInstanceOf(InvoiceApproveResponseDTO::class, $result);
    }

    public function testApproveNotFound(): void
    {
        $dto = new InvoiceApproveRequestDTO('123');
        $this->invoiceRepository
            ->expects($this->once())
            ->method('getDetails')
            ->with('123')
            ->willThrowException(new InvoiceNotFoundException('123'));

        $this->expectException(InvoiceNotFoundException::class);
        $this->invoiceFacade->approve($dto);
    }

    public function testApproveAlreadyApproved(): void
    {
        $dto = new InvoiceApproveRequestDTO('123');
        $invoiceModel = $this->createInvoiceModel(StatusEnum::APPROVED);

        $this->invoiceRepository
            ->expects($this->once())
            ->method('getDetails')
            ->with('123')
            ->willReturn($invoiceModel);

        $this->approvalFacade
            ->expects($this->once())
            ->method('approve')
            ->willThrowException(new LogicException('approval status is already assigned'));

        $this->expectException(InvoiceCanNotBeApprovedException::class);
        $this->invoiceFacade->approve($dto);
    }
}
