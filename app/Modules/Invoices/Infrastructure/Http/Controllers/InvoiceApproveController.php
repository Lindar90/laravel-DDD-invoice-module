<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Infrastructure\Http\Response\JsonBadRequestResponse;
use App\Infrastructure\Http\Response\JsonErrorResponse;
use App\Infrastructure\Http\Response\JsonSuccessResponse;
use App\Modules\Invoices\API\DTO\InvoiceApproveRequestDTO;
use App\Modules\Invoices\API\InvoiceFacadeInterface;
use App\Modules\Invoices\Domain\Exceptions\InvoiceCanNotBeApprovedException;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Log\LogManager;

readonly class InvoiceApproveController
{
    public function __construct(
        private InvoiceFacadeInterface $invoiceFacade,
        private LogManager $logger,
    ) {
    }

    public function __invoke(string $id): JsonResponse
    {
        $dto = new InvoiceApproveRequestDTO($id);

        try {
            $responseDTO = $this->invoiceFacade->approve($dto);

            return new JsonSuccessResponse($responseDTO->toArray());
        } catch (InvoiceNotFoundException $e) {
            $this->logger->warning($e->getMessage());

            return new JsonBadRequestResponse('Invoice not found', [
                'id' => 'Invoice not found',
            ]);
        } catch (InvoiceCanNotBeApprovedException $e) {
            $this->logger->warning($e->getMessage());

            return new JsonBadRequestResponse('Invoice can not be approved', [
                'id' => 'Invoice can not be approved',
            ]);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return new JsonErrorResponse();
        }
    }
}
