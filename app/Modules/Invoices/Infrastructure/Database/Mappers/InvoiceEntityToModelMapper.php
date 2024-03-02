<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Mappers;

use App\Domain\Enums\StatusEnum;
use App\Domain\Models\CompanyModel;
use App\Modules\Invoices\Domain\Models\InvoiceModel;
use App\Modules\Invoices\Domain\Models\InvoiceProductLineModel;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceEntity;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceProductLineEntity as InvoiceProductLineEntity;
use Ramsey\Uuid\Uuid;

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
            id: Uuid::fromString($invoice->id),
            number: $invoice->number,
            date: $invoice->date,
            dueDate: $invoice->due_date,
            status: $invoice->status,
            updatedAt: $invoice->updated_at->toString(),
            billToCompany: $company,
            shipToCompany: $company,
            productLines: $productLines,
        );
    }
}
