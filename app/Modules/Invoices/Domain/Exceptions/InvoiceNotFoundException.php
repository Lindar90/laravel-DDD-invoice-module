<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Exceptions;

use Exception;

class InvoiceNotFoundException extends Exception
{
    public function __construct(string $id)
    {
        parent::__construct("Invoice with id $id not found");
    }
}
