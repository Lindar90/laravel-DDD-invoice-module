<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http\Controllers;

class InvoiceApproveController
{
    public function __invoke(string $id): \Illuminate\Http\JsonResponse
    {
        return response()->json(['id' => $id]);
    }
}
