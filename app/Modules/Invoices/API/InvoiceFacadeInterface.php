<?php

declare(strict_types=1);

namespace App\Modules\Invoices\API;

use App\Modules\Invoices\API\DTO\InvoiceApproveRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceApproveResponseDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO;
use App\Modules\Invoices\API\DTO\InvoiceRejectRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceRejectResponseDTO;
use App\Modules\Invoices\Domain\Exceptions\InvoiceCanNotBeApprovedException;
use App\Modules\Invoices\Domain\Exceptions\InvoiceCanNotBeRejectedException;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;

interface InvoiceFacadeInterface
{
    /**
     * @throws InvoiceNotFoundException
     */
    public function getDetails(InvoiceDetailsRequestDTO $dto): InvoiceDetailsResponseDTO;

    /**
     * @throws InvoiceCanNotBeApprovedException|InvoiceNotFoundException
     */
    public function approve(InvoiceApproveRequestDTO $dto): InvoiceApproveResponseDTO;

    /**
     * @throws InvoiceCanNotBeRejectedException|InvoiceNotFoundException
     */
    public function reject(InvoiceRejectRequestDTO $dto): InvoiceRejectResponseDTO;
}
