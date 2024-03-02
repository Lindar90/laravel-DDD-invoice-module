<?php

declare(strict_types=1);

use App\Modules\Invoices\Infrastructure\Http\Controllers\InvoiceApproveController;
use App\Modules\Invoices\Infrastructure\Http\Controllers\InvoiceDetailsController;
use App\Modules\Invoices\Infrastructure\Http\Controllers\InvoiceRejectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/invoice')->group(static function (): void {
    Route::get('/{id}', InvoiceDetailsController::class);
    Route::post('/{id}/approve', InvoiceApproveController::class);
    Route::post('/{id}/reject', InvoiceRejectController::class);
});
