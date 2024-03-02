<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Infrastructure\Http\Response\JsonBadRequestResponse;
use App\Infrastructure\Http\Response\JsonErrorResponse;
use App\Infrastructure\Http\Response\JsonSuccessResponse;
use App\Modules\Invoices\API\DTO\InvoiceRejectRequestDTO;
use App\Modules\Invoices\API\InvoiceFacadeInterface;
use App\Modules\Invoices\Domain\Exceptions\InvoiceCanNotBeRejectedException;
use App\Modules\Invoices\Domain\Exceptions\InvoiceNotFoundException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Log\LogManager;

readonly class InvoiceRejectController
{
    public function __construct(
        private InvoiceFacadeInterface $invoiceFacade,
        private LogManager $logger
    ) {
    }

    public function __invoke(string $id): JsonResponse
    {
        $dto = new InvoiceRejectRequestDTO($id);

        try {
            $responseDTO = $this->invoiceFacade->reject($dto);

            return new JsonSuccessResponse($responseDTO->toArray());
        } catch (InvoiceNotFoundException $e) {
            $this->logger->warning($e->getMessage());

            return new JsonBadRequestResponse('Invoice not found', [
                'id' => 'Invoice not found',
            ]);
        } catch (InvoiceCanNotBeRejectedException $e) {
            $this->logger->warning($e->getMessage());

            return new JsonBadRequestResponse('Invoice can not be rejected', [
                'id' => 'Invoice can not be rejected',
            ]);
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            return new JsonErrorResponse();
        }
    }
}
