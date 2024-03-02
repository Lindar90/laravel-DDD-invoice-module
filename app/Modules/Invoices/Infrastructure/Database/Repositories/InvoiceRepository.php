<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Repositories;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use App\Modules\Invoices\Domain\Models\InvoiceModel;
use App\Modules\Invoices\Domain\Repositories\InvoiceRepositoryInterface;
use App\Modules\Invoices\Infrastructure\Database\Entities\InvoiceEntity;
use App\Modules\Invoices\Infrastructure\Database\Mappers\InvoiceEntityToModelMapper;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    /**
     * @throws InvoiceNotFoundException
     */
    public function getDetails(string $id): InvoiceModel
    {
        /** @var InvoiceEntity|null $invoice */
        $invoice = InvoiceEntity::with(['company', 'productLines', 'productLines.product'])->find($id);

        if (null === $invoice) {
            throw new InvoiceNotFoundException($id);
        }

        return InvoiceEntityToModelMapper::map($invoice);
    }

    /**
     * @throws InvoiceNotFoundException
     */
    public function approve(string $id): InvoiceModel
    {
        return $this->updateInvoiceStatus($id, StatusEnum::APPROVED);
    }

    /**
     * @throws InvoiceNotFoundException
     */
    public function reject(string $id): InvoiceModel
    {
        return $this->updateInvoiceStatus($id, StatusEnum::REJECTED);
    }

    /**
     * @throws InvoiceNotFoundException
     */
    private function updateInvoiceStatus(string $id, StatusEnum $status): InvoiceModel
    {
        /** @var InvoiceEntity|null $invoice */
        $invoice = InvoiceEntity::find($id);

        if (null === $invoice) {
            throw new InvoiceNotFoundException($id);
        }

        $invoice->status = $status;
        $invoice->save();

        return InvoiceEntityToModelMapper::map($invoice);
    }
}
