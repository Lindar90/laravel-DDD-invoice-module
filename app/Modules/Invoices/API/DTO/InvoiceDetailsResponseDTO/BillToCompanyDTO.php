<?php

declare(strict_types=1);

namespace App\Modules\Invoices\API\DTO\InvoiceDetailsResponseDTO;

class BillToCompanyDTO extends ShipToCompanyDTO
{
    private string $email;

    public function __construct(
        string $name,
        string $address,
        string $city,
        string $zipCode,
        string $phone,
        string $email
    ) {
        parent::__construct($name, $address, $city, $zipCode, $phone);

        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
