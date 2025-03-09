<?php

use App\Http\Controllers\Student\StudentAuthController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Student\StudentManagementController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    // Student routes
    Route::prefix('student')->group(function () {
        Route::post('register', [StudentController::class, 'register']);
        Route::post('login', [StudentAuthController::class, 'login']);
        Route::post('logout', [StudentAuthController::class, 'logout'])->middleware('auth:student');
    });
});

Route::middleware(['auth:student'])->prefix('student')->group(function () {
    Route::get('profile', [StudentAuthController::class, 'profile']);
});
