<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\API\DTO\InvoiceDetailsRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO;
use App\Modules\Invoices\API\InvoiceFacadeInterface;
use App\Modules\Invoices\Application\Mappers\InvoiceModelToResponseDTOMapper;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;

readonly class InvoiceFacade implements InvoiceFacadeInterface
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository
    ) {
    }

    /**
     * @throws InvoiceNotFoundException
     */
    public function getDetails(InvoiceDetailsRequestDTO $dto): InvoiceDetailsResponseDTO
    {
        $invoice = $this->invoiceRepository->getDetails($dto->getId());

        return InvoiceModelToResponseDTOMapper::map($invoice);
    }
}
