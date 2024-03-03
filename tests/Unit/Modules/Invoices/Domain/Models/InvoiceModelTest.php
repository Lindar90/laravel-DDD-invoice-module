<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Domain\Enums\StatusEnum;
use App\Domain\Models\CompanyModel;
use App\Modules\Invoices\Domain\Models\InvoiceModel;
use App\Modules\Invoices\Domain\Models\InvoiceProductLineModel;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class InvoiceModelTest extends TestCase
{
    public function testInvoiceTotalPrice(): void
    {
        $model = $this->createModel();

        $this->assertEquals(500, $model->getTotalPrice());
    }

    private function createModel(): InvoiceModel
    {
        $company = new CompanyModel(
            id: '123',
            name: 'Test',
            streetAddress: 'Test 123',
            city: 'Test City',
            zip: '12345',
            phone: '123456789',
            email: 'test@email.com'
        );

        $productLines = [
            new InvoiceProductLineModel(
                name: 'Test',
                quantity: 1,
                unitPrice: 100,
            ),
            new InvoiceProductLineModel(
                name: 'Test 2',
                quantity: 2,
                unitPrice: 200,
            ),
        ];


        return new InvoiceModel(
            id: Uuid::uuid4(),
            number: 'a7f028af-4d0a-4ad5-b22b-e3296f44e698',
            date: '2021-01-01',
            dueDate: '2021-01-31',
            status: StatusEnum::DRAFT,
            updatedAt: '2021-01-01',
            billToCompany: $company,
            shipToCompany: $company,
            productLines: $productLines,
        );
    }
}
