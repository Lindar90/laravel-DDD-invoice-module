<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Application\Mappers;

use App\Modules\Invoices\API\DTO\InvoiceRejectResponseDTO;
use App\Modules\Invoices\Domain\Models\InvoiceModel;

enum InvoiceModelToInvoiceRejectResponseDTO
{
    public static function map(InvoiceModel $model): InvoiceRejectResponseDTO
    {
        return new InvoiceRejectResponseDTO(
            id: $model->getId(),
            rejectedDate: $model->getUpdatedAt(),
        );
    }
}
