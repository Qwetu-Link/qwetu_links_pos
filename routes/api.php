<?php

use App\Http\Controllers\Api\v1\account\BusinessController;
use App\Http\Controllers\Api\v1\auth\AuthController;
use App\Http\Controllers\Api\v1\product\ProductCatalogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\v1'], function () {

    Route::post('businesses', [BusinessController::class, 'store']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/verify-email', [AuthController::class, 'verify'])->name('verify.email');

});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\v1'], function () {

    Route::apiResource('products', ProductCatalogController::class);

    // Table likely does have business_id
    // Route::prefix('businesses/{business}')->group(function () {
    //     // Route::apiResource('users', UserController::class);
    //     Route::apiResource('properties', PropertyController::class);

    //     Route::apiResource('staff', StaffController::class);
    //     Route::apiResource('tenants', TenantController::class);

    //     Route::apiResource('units', UnitsController::class);
    //     Route::apiResource('amenities', AmenityController::class);

    //     Route::apiResource('leases', LeaseController::class);
    //     Route::apiResource('invoices', InvoiceController::class);
    //     Route::apiResource('payments', PaymentController::class);
    //     Route::apiResource('maintainance', MaintainanceController::class);

    //     Route::post('/logout', [AuthController::class, 'logout']);
    // });

    // Table likely does NOT have business_id
    // Route::prefix('businesses')->group(function () {

    // });
});
