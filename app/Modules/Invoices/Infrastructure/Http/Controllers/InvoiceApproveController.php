<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

use App\Infrastructure\Http\Response\JsonBadRequestResponse;
use App\Infrastructure\Http\Response\JsonErrorResponse;
use App\Infrastructure\Http\Response\JsonSuccessResponse;
use App\Modules\Invoices\API\DTO\InvoiceApproveRequestDTO;
use App\Modules\Invoices\API\InvoiceFacadeInterface;
use App\Modules\Invoices\Domain\Exceptions\InvoiceCanNotBeApprovedException;
use Exception;
use Illuminate\Http\JsonResponse;

readonly class InvoiceApproveController
{
    public function __construct(
        private InvoiceFacadeInterface $invoiceFacade
    ) {
    }

    public function __invoke(string $id): JsonResponse
    {
        $dto = new InvoiceApproveRequestDTO($id);

        try {
            $responseDTO = $this->invoiceFacade->approve($dto);

            return new JsonSuccessResponse($responseDTO->toArray());
        } catch (InvoiceCanNotBeApprovedException $e) {
            return new JsonBadRequestResponse('Invoice can not be approved', [
                'id' => 'Invoice can not be approved',
            ]);
        } catch (Exception $e) {
            return new JsonErrorResponse();
        }
    }
}
