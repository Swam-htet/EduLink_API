<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Management\TenantConfigController;
use App\Http\Resources\TenantResource;
use App\Contracts\Services\MailServiceInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Jobs\SendWelcomeEmail;

// test routes
Route::group(['prefix' => 'test'], function () {
    Route::get('/', function (Request $request) {
        return response()->json(['message' => 'Hello, World!', 'tenant' => new TenantResource($request->attributes->get('tenant'))]);
    });

    // test mail with queue
    Route::post('/mail', function (Request $request) {
        SendWelcomeEmail::dispatch('test@test.com', 'Test User')
            ->onQueue('emails');

        return response()->json(['message' => 'Mail queued for sending']);
    });

    // test cache operations
    Route::get('/cache/test', function (Request $request) {
        // Set some test values
        Cache::put('test_string', 'Hello from Cache!', 3600); // 1 hour
        Cache::put('test_array', ['key' => 'value'], 3600);

        // Get the values back
        $string = Cache::get('test_string');
        $array = Cache::get('test_array');

        return response()->json([
            'success' => true,
            'data' => [
                'cache' => [
                    'string' => $string,
                    'array' => $array,
                    'missing' => Cache::get('non_existent', 'default_value')
                    ],
            ]
        ]);
    });

});

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
