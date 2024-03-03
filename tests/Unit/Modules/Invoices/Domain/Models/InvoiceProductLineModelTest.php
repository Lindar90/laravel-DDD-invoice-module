<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Models;

use App\Modules\Invoices\Domain\Models\InvoiceProductLineModel;
use PHPUnit\Framework\TestCase;

class InvoiceProductLineModelTest extends TestCase
{
    public function testGetTotal(): void
    {
        $model = $this->createModel();

        $this->assertEquals(200, $model->getTotal());
    }

    private function createModel(): InvoiceProductLineModel
    {
        return new InvoiceProductLineModel(
            name: 'Test',
            quantity: 2,
            unitPrice: 100,
        );
    }
}
