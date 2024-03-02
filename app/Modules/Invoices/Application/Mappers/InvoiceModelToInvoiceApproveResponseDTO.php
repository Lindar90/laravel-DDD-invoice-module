<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mappers;

use App\Modules\Invoices\API\DTO\InvoiceApproveResponseDTO;
use App\Modules\Invoices\Domain\Models\InvoiceModel;

class InvoiceModelToInvoiceApproveResponseDTO
{
    public static function map(InvoiceModel $model): InvoiceApproveResponseDTO
    {
        return new InvoiceApproveResponseDTO(
            id: $model->getId(),
            approvedDate: $model->getUpdatedAt(),
        );
    }
}
