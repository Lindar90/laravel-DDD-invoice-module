<?php

declare(strict_types=1);

namespace App\Modules\Invoices\API;

use App\Modules\Invoices\API\DTO\InvoiceDetailsRequestDTO;
use App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;

interface InvoiceFacadeInterface
{
    /**
     * @throws InvoiceNotFoundException
     */
    public function getDetails(InvoiceDetailsRequestDTO $dto): InvoiceDetailsResponseDTO;
}
