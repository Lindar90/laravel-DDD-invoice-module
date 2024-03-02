<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Repositories;

use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Domain\Models\InvoiceModel;

interface InvoiceRepositoryInterface
{
    /**
     * @throws InvoiceNotFoundException
     */
    public function getDetails(string $id): InvoiceModel;

    public function approve(string $id): InvoiceModel;
}
