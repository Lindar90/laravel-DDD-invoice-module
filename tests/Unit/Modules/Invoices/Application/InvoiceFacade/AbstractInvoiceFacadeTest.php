<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Application\InvoiceFacade;

use App\Domain\Enums\StatusEnum;
use App\Domain\Models\CompanyModel;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Application\InvoiceFacade;
use App\Modules\Invoices\Domain\Models\InvoiceModel;
use App\Modules\Invoices\Infrastructure\Database\Repositories\InvoiceRepository;
use Illuminate\Log\LogManager;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

abstract class AbstractInvoiceFacadeTest extends TestCase
{
    protected $invoiceRepository;

    protected $approvalFacade;

    protected $logger;

    protected $invoiceFacade;

    public function setUp(): void
    {
        $this->invoiceRepository = $this->createMock(InvoiceRepository::class);
        $this->approvalFacade = $this->createMock(ApprovalFacadeInterface::class);
        $this->logger = $this->createMock(LogManager::class);

        $this->invoiceFacade = new InvoiceFacade(
            $this->invoiceRepository,
            $this->approvalFacade,
            $this->logger
        );
    }

    protected function createInvoiceModel(StatusEnum $status = StatusEnum::DRAFT): InvoiceModel
    {
        $company = new CompanyModel(
            id: '123',
            name: 'Test',
            streetAddress: 'Test 123',
            city: 'Test City',
            zip: '12345',
            phone: '123456789',
            email: 'test@email.com',
        );

        return new InvoiceModel(
            id: Uuid::uuid4(),
            number: 'a7f028af-4d0a-4ad5-b22b-e3296f44e698',
            date: '2021-01-01',
            dueDate: '2021-01-31',
            status: $status,
            updatedAt: '2021-01-01',
            billToCompany: $company,
            shipToCompany: $company,
            productLines: [],
        );
    }
}
