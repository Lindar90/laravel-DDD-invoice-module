<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Mappers;

use App\Domain\Models\CompanyModel;
use App\Modules\Invoices\Domain\Models\InvoiceModel as InvoiceModel;
use App\Modules\Invoices\Domain\Models\InvoiceProductLineModel as InvoiceProductLineModel;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceEntity as InvoiceEntity;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceProductLineEntity as InvoiceProductLineEntity;

class InvoiceEntityToModelMapper
{
    public static function map(InvoiceEntity $invoice): InvoiceModel
    {
        $company = new CompanyModel(
            id: $invoice->company->id,
            name: $invoice->company->name,
            streetAddress: $invoice->company->street,
            city: $invoice->company->city,
            zip: $invoice->company->zip,
            phone: $invoice->company->phone,
            email: $invoice->company->email,
        );

        $productLines = $invoice->productLines->map(function (InvoiceProductLineEntity $productLine) {
            return new InvoiceProductLineModel(
                name: $productLine->product->name,
                quantity: $productLine->quantity,
                unitPrice: $productLine->product->price,
            );
        })->toArray();

        return new InvoiceModel(
            id: $invoice->id,
            number: $invoice->number,
            date: $invoice->date,
            dueDate: $invoice->due_date,
            billToCompany: $company,
            shipToCompany: $company,
            productLines: $productLines,
        );
    }
}
