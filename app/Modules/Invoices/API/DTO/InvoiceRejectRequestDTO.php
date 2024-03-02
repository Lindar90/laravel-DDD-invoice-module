<?php

declare(strict_types=1);

namespace App\Modules\Invoices\API\DTO;

use App\API\DTO\AbstractDTO;

class InvoiceRejectRequestDTO extends AbstractDTO
{
    public function __construct(
        private readonly string $id
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
