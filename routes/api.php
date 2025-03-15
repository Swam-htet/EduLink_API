<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Management\TenantConfigController;
use App\Http\Resources\TenantResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

// test routes
Route::group(['prefix' => 'test'], function () {
    Route::get('/', function (Request $request) {
        return response()->json(['message' => 'Hello, World!', 'tenant' => new TenantResource($request->attributes->get('tenant'))]);
    });

    // test mail with queue
    Route::post('/mail', function (Request $request) {
        // todo : need to implement queue for better performance
        Mail::to('test@test.com')->send(new WelcomeMail('test@test.com', 'Test User'));
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

    // test file upload
    Route::post('/upload', function (Request $request) {
        $file = $request->file('file');
        dd($file);

        return response()->json(['message' => 'File uploaded successfully']);
    });


});

Route::prefix('management')->group(function () {
    Route::prefix('config')->group(function () {
        Route::get('/', [TenantConfigController::class, 'index']);
        Route::get('/{key}', [TenantConfigController::class, 'show']);
        Route::get('/group/{group}', [TenantConfigController::class, 'getByGroup']);
        Route::post('/', [TenantConfigController::class, 'store']);
        Route::delete('/{key}', [TenantConfigController::class, 'destroy']);
    });
});
