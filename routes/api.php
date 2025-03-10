<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Management\TenantConfigController;



Route::prefix('management')->group(function () {
    Route::prefix('config')->group(function () {
        Route::get('/', [TenantConfigController::class, 'index']);
        Route::get('/{key}', [TenantConfigController::class, 'show']);
        Route::get('/group/{group}', [TenantConfigController::class, 'getByGroup']);
        Route::post('/', [TenantConfigController::class, 'store']);
        Route::put('/{key}', [TenantConfigController::class, 'update']);
        Route::delete('/{key}', [TenantConfigController::class, 'destroy']);
        Route::post('/bulk-update', [TenantConfigController::class, 'bulkUpdate']);
    });
});
