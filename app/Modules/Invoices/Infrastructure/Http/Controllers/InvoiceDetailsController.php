<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Infrastructure\Controller;
use App\Infrastructure\Http\Response\JsonBadRequestResponse;
use App\Infrastructure\Http\Response\JsonErrorResponse;
use App\Infrastructure\Http\Response\JsonSuccessResponse;
use App\Modules\Invoices\API\DTO\InvoiceDetailsRequestDTO;
use App\Modules\Invoices\API\InvoiceFacadeInterface;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Log\LogManager;

class InvoiceDetailsController extends Controller
{
    public function __construct(
        private readonly InvoiceFacadeInterface $invoiceFacade,
        private readonly LogManager $logger
    ) {
    }

    public function __invoke(string $id): JsonResponse
    {
        $dto = new InvoiceDetailsRequestDTO($id);

        try {
            $responseDTO = $this->invoiceFacade->getDetails($dto);

            return new JsonSuccessResponse($responseDTO->toArray());
        } catch (InvoiceNotFoundException $e) {
            $this->logger->warning($e->getMessage());

            return new JsonBadRequestResponse('Invoice not found', [
                'id' => 'Invoice not found',
            ]);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return new JsonErrorResponse();
        }
    }
}
