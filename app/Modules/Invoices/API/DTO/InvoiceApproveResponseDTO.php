<?php

declare(strict_types=1);

namespace App\Modules\Invoices\API\DTO;

use App\API\DTO\AbstractDTO;

class InvoiceApproveResponseDTO extends AbstractDTO
{
    public function __construct(
        private readonly string $id,
        private readonly string $approvedDate
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getApprovedDate(): string
    {
        return $this->approvedDate;
    }
}
