<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\API\DTO\InvoiceApproveRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceApproveResponseDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO;
use App\Modules\Invoices\API\InvoiceFacadeInterface;
use App\Modules\Invoices\Application\Mappers\InvoiceModelToInvoiceApproveResponseDTO;
use App\Modules\Invoices\Application\Mappers\InvoiceModelToInvoiceDetailsResponseDTOMapper;
use App\Modules\Invoices\Domain\Exceptions\InvoiceCanNotBeApprovedException;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use Illuminate\Log\LogManager;
use LogicException;

readonly class InvoiceFacade implements InvoiceFacadeInterface
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private ApprovalFacadeInterface $approvalFacade,
        private LogManager $logger,
    ) {
    }

    /**
     * @throws InvoiceNotFoundException
     */
    public function getDetails(InvoiceDetailsRequestDTO $dto): InvoiceDetailsResponseDTO
    {
        $invoiceModel = $this->invoiceRepository->getDetails($dto->getId());

        return InvoiceModelToInvoiceDetailsResponseDTOMapper::map($invoiceModel);
    }

    /**
     * @throws InvoiceCanNotBeApprovedException|InvoiceNotFoundException
     */
    public function approve(InvoiceApproveRequestDTO $dto): InvoiceApproveResponseDTO
    {
        $invoice = $this->invoiceRepository->getDetails($dto->getId());

        $approvalDto = new ApprovalDto(
            id: $invoice->getId(),
            status: $invoice->getStatus(),
            entity: 'invoice',
        );

        try {
            $this->approvalFacade->approve($approvalDto);

            $invoiceModel = $this->invoiceRepository->approve($dto->getId());

            return  InvoiceModelToInvoiceApproveResponseDTO::map($invoiceModel);
        } catch (LogicException $e) {
            $this->logger->warning($e->getMessage());
            throw new InvoiceCanNotBeApprovedException($dto->getId());
        }
    }
}
