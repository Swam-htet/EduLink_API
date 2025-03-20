<?php

use Illuminate\Support\Facades\Route;


// auth api group
Route::prefix('auth')->group(function () {
    Route::group(['prefix' => 'student'], function () {
        Route::post('/login', [App\Http\Controllers\Auth\StudentAuthController::class, 'login']);
        Route::group(['middleware' => 'auth:student'], function () {
            Route::post('/logout', [App\Http\Controllers\Auth\StudentAuthController::class, 'logout']);

            Route::get('/profile', [App\Http\Controllers\Auth\StudentAuthController::class, 'getProfile']);
        });
        // // forget password
        // Route::post('/forget-password', [App\Http\Controllers\Auth\StudentAuthController::class, 'forgetPassword']);

        // // reset password
        // Route::post('/reset-password', [App\Http\Controllers\Auth\StudentAuthController::class, 'resetPassword']);

        // // update password
        // Route::post('/update-password', [App\Http\Controllers\Auth\StudentAuthController::class, 'updatePassword']);
    });

    Route::group(['prefix' => 'staff'], function () {
        Route::post('/login', [App\Http\Controllers\Auth\StaffAuthController::class, 'login']);

        Route::group(['middleware' => 'auth:staff'], function () {
            Route::post('/logout', [App\Http\Controllers\Auth\StaffAuthController::class, 'logout']);

            Route::get('/profile', [App\Http\Controllers\Auth\StaffAuthController::class, 'getProfile']);
        });
    });
});


Route::prefix('students')->group(function () {
    Route::post('/register', [App\Http\Controllers\StudentController::class, 'register']);

    // update student profile
    // Route::put('/update-profile', [App\Http\Controllers\Auth\StudentController::class, 'updateProfile']);
});

Route::prefix('staff')->group(function () {
    // update staff profile
    // Route::put('/update-profile', [App\Http\Controllers\Auth\StaffController::class, 'updateProfile']);

    // reset password
    // Route::post('/reset-password', [App\Http\Controllers\Auth\StaffController::class, 'resetPassword']);
});

// management api group with staff guard middleware
// todo : need to add middleware for this management route group
Route::prefix('management')->group(function () {
    Route::prefix('students')->group(function () {

        Route::get('/', [App\Http\Controllers\StudentManagementController::class, 'index']);

        Route::post('/approve-registration', [App\Http\Controllers\StudentManagementController::class, 'approveRegistration']);

        Route::post('/reject-registration', [App\Http\Controllers\StudentManagementController::class, 'rejectRegistration']);
    });


    // staff api group
    Route::prefix('staff')->group(function () {

        // check all staffs
        Route::get('/', [App\Http\Controllers\StaffManagementController::class, 'index']);

        // check a staff
        Route::get('/{id}', [App\Http\Controllers\StaffManagementController::class, 'show']);

        // create a staff
        Route::post('/', [App\Http\Controllers\StaffManagementController::class, 'create']);

        // // update staff
        // Route::put('/{id}', [App\Http\Controllers\StaffManagementController::class, 'update']);

        // // reset staff password
        // Route::get('/{id}/reset-password', [App\Http\Controllers\StaffManagementController::class, 'resetPassword']);
    });

    // course api group
    Route::prefix('courses')->group(function () {
        Route::get('/', [App\Http\Controllers\CourseManagementController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\CourseManagementController::class, 'show']);
        Route::post('/', [App\Http\Controllers\CourseManagementController::class, 'store']);
        Route::put('/{id}', [App\Http\Controllers\CourseManagementController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\CourseManagementController::class, 'destroy']);
    });

    // subject api group
    Route::prefix('subjects')->group(function () {
        Route::get('/', [App\Http\Controllers\SubjectManagementController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'show']);
        Route::post('/', [App\Http\Controllers\SubjectManagementController::class, 'store']);
        Route::put('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'update']);
    });

    // class api group
    Route::prefix('classes')->group(function () {
        Route::get('/', [App\Http\Controllers\ClassManagementController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\ClassManagementController::class, 'show']);
        Route::post('/', [App\Http\Controllers\ClassManagementController::class, 'store']);
        Route::put('/{id}', [App\Http\Controllers\ClassManagementController::class, 'update']);
    });

    // enroll student to class
    Route::prefix('class-enrollments')->group(function () {
        Route::get('/', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'index']);

        Route::put('/{id}', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'update']);

        Route::post('/', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'enrollStudent']);

        // sent manual class enrollment email
        Route::post('/send-email', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'sendManualEnrollmentEmail']);

        Route::post('/confirm/{token?}', [App\Http\Controllers\ClassEnrollmentController::class, 'confirmEnrollment']);
    });

    // class schedule api group
    Route::prefix('class-schedules')->group(function () {
        Route::get('/', [App\Http\Controllers\ClassScheduleManagementController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\ClassScheduleManagementController::class, 'show']);
        Route::post('/', [App\Http\Controllers\ClassScheduleManagementController::class, 'store']);
    });

    // config api group
    Route::prefix('config')->group(function () {
        Route::get('/', [App\Http\Controllers\TenantConfigController::class, 'index']);
        Route::post('/', [App\Http\Controllers\TenantConfigController::class, 'store']);
        Route::delete('/{key}', [App\Http\Controllers\TenantConfigController::class, 'destroy']);
    });

    // attendance api group
    Route::prefix('attendance')->group(function () {
        // manual attendance making by staff
        // Route::post('/', [App\Http\Controllers\AttendanceController::class, 'makeAttendance']);

        // get all attendances by student id
        // Route::get('/student/{id}', [App\Http\Controllers\AttendanceController::class, 'getAttendancesByStudentId']);
    });
});

// course api group
Route::prefix('courses')->group(function () {
    Route::get('/', [App\Http\Controllers\CourseController::class, 'index']);
    Route::get('/{id}', [App\Http\Controllers\CourseController::class, 'show']);
});

// subject api group
Route::prefix('subjects')->group(function () {
    Route::get('/', [App\Http\Controllers\SubjectController::class, 'index']);
    Route::get('/{id}', [App\Http\Controllers\SubjectController::class, 'show']);
});

// class api group
Route::prefix('classes')->group(function () {
    Route::get('/', [App\Http\Controllers\ClassController::class, 'index']);
    Route::get('/{id}', [App\Http\Controllers\ClassController::class, 'show']);
});


Route::prefix('class-enrollments')->group(function () {
    Route::post('/confirm', [App\Http\Controllers\ClassEnrollmentController::class, 'confirmEnrollment']);
});

// class schedule api group
Route::prefix('class-schedule')->group(function () {
    // get all class schedules
    // Route::get('/', [App\Http\Controllers\ClassScheduleController::class, 'index']);
    // get a class schedule
    // Route::get('/{id}', [App\Http\Controllers\ClassScheduleController::class, 'show']);
});

// attendance api group
Route::prefix('attendance')->group(function () {
    // make attendance
    // Route::post('/', [App\Http\Controllers\AttendanceController::class, 'makeAttendance']);

    // get all attendances by student id
    // Route::get('/student/{id}', [App\Http\Controllers\AttendanceController::class, 'getAttendancesByStudentId']);
});
