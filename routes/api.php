<?php

use App\Http\Controllers\Student\StudentAuthController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentManagementController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello World'
    ]);
});

// test group
Route::group(['prefix' => 'test'], function () {
    Route::get('/', function () {
        return response()->json([
            'message' => 'Hello World'
        ]);
    });

    // test mail
    Route::post('/mail', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string'
        ]);
        Mail::to($request->email)->send(new WelcomeMail($request->email, $request->name));
        return response()->json([
            'message' => 'Mail sent'
        ]);
    });
});

// Public routes
Route::prefix('auth')->group(function () {
    // Student routes
    Route::prefix('student')->group(function () {
        Route::post('register', [StudentController::class, 'register']);
        Route::post('login', [StudentAuthController::class, 'login']);
    });

    // Staff routes
    Route::prefix('staff')->group(function () {
        Route::post('register', [StaffAuthController::class, 'register']);
        Route::post('login', [StaffAuthController::class, 'login']);
    });
});

// Protected Student routes
Route::middleware(['auth:student', 'scope:student'])->prefix('student')->group(function () {
    // Auth routes
    Route::post('logout', [StudentAuthController::class, 'logout']);
    Route::get('profile', [StudentAuthController::class, 'profile']);
});

// Protected Staff routes
Route::middleware(['auth:staff', 'scope:staff'])->prefix('staff')->group(function () {
    // Auth routes
    Route::post('logout', [StaffAuthController::class, 'logout']);
    Route::get('profile', [StaffAuthController::class, 'profile']);

    // Student Management routes (admin only)
    Route::middleware(['scope:admin'])->prefix('students')->group(function () {
        Route::get('/', [StudentManagementController::class, 'index']);
        Route::get('/{id}', [StudentManagementController::class, 'show']);
        Route::put('/{id}', [StudentManagementController::class, 'update']);
        Route::delete('/{id}', [StudentManagementController::class, 'destroy']);
    });
});
