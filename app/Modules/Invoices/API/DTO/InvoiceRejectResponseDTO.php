<?php

declare(strict_types=1);

namespace App\Modules\Invoices\API\DTO;

use App\API\DTO\AbstractDTO;
use Ramsey\Uuid\UuidInterface;

class InvoiceRejectResponseDTO extends AbstractDTO
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly string $rejectedDate
    ) {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRejectedDate(): string
    {
        return $this->rejectedDate;
    }
}
