<?php

use Illuminate\Support\Facades\Route;


// auth api group
Route::prefix('auth')->group(function () {
    Route::group(['prefix' => 'student'], function () {
        // login for student
        Route::post('/login', [App\Http\Controllers\Auth\StudentAuthController::class, 'login']);
        Route::group(['middleware' => 'auth:student'], function () {
            // logout for student
            Route::post('/logout', [App\Http\Controllers\Auth\StudentAuthController::class, 'logout']);

            // get student profile
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
        // login for staff
        Route::post('/login', [App\Http\Controllers\Auth\StaffAuthController::class, 'login']);

        Route::group(['middleware' => 'auth:staff'], function () {
            // logout for staff
            Route::post('/logout', [App\Http\Controllers\Auth\StaffAuthController::class, 'logout']);

            // get staff profile
            Route::get('/profile', [App\Http\Controllers\Auth\StaffAuthController::class, 'getProfile']);
        });
    });
});


Route::prefix('students')->group(function () {
    // register for student
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
        // get all students for management
        Route::get('/', [App\Http\Controllers\StudentManagementController::class, 'index']);

        // approve student registration for management
        Route::post('/approve-registration', [App\Http\Controllers\StudentManagementController::class, 'approveRegistration']);

        // reject student registration for management
        Route::post('/reject-registration', [App\Http\Controllers\StudentManagementController::class, 'rejectRegistration']);
    });


    // staff api group
    Route::prefix('staff')->group(function () {

        // get all staffs for management
        Route::get('/', [App\Http\Controllers\StaffManagementController::class, 'index']);

        // get a staff for management
        Route::get('/{id}', [App\Http\Controllers\StaffManagementController::class, 'show']);

        // create a staff by management
        Route::post('/', [App\Http\Controllers\StaffManagementController::class, 'create']);

        // // update staff
        // Route::put('/{id}', [App\Http\Controllers\StaffManagementController::class, 'update']);

        // // reset staff password
        // Route::get('/{id}/reset-password', [App\Http\Controllers\StaffManagementController::class, 'resetPassword']);
    });

    // course api group
    Route::prefix('courses')->group(function () {
        // get all courses for management
        Route::get('/', [App\Http\Controllers\CourseManagementController::class, 'index']);

        // get a course for management
        Route::get('/{id}', [App\Http\Controllers\CourseManagementController::class, 'show']);

        // create a course by management
        Route::post('/', [App\Http\Controllers\CourseManagementController::class, 'store']);

        // update a course by management
        Route::put('/{id}', [App\Http\Controllers\CourseManagementController::class, 'update']);

        // delete a course by management
        Route::delete('/{id}', [App\Http\Controllers\CourseManagementController::class, 'destroy']);
    });

    // subject api group
    Route::prefix('subjects')->group(function () {
        // get all subjects for management
        Route::get('/', [App\Http\Controllers\SubjectManagementController::class, 'index']);

        // get a subject for management
        Route::get('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'show']);

        // create a subject by management
        Route::post('/', [App\Http\Controllers\SubjectManagementController::class, 'store']);

        // update a subject by management
        Route::put('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'update']);
    });

    // class api group
        Route::prefix('classes')->group(function () {
        // get all classes for management
        Route::get('/', [App\Http\Controllers\ClassManagementController::class, 'index']);

        // get a class for management
        Route::get('/{id}', [App\Http\Controllers\ClassManagementController::class, 'show']);

        // create a class by management
        Route::post('/', [App\Http\Controllers\ClassManagementController::class, 'store']);

        // update a class by management
        Route::put('/{id}', [App\Http\Controllers\ClassManagementController::class, 'update']);
    });

    // enroll student to class
    Route::prefix('class-enrollments')->group(function () {
        // get all class enrollments for management
        Route::get('/', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'index']);

        // update a class enrollment by management
        Route::put('/{id}', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'update']);

        // enroll student to class
        Route::post('/', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'enrollStudent']);

        // send manual enrollment email
        Route::post('/send-email', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'sendManualEnrollmentEmail']);
    });

    // class schedule api group
    Route::prefix('class-schedules')->group(function () {
        // get all class schedules for management
        Route::get('/', [App\Http\Controllers\ClassScheduleManagementController::class, 'index']);

        // get a class schedule for management
        Route::get('/{id}', [App\Http\Controllers\ClassScheduleManagementController::class, 'show']);

        // create a class schedule by management
        Route::post('/', [App\Http\Controllers\ClassScheduleManagementController::class, 'store']);

        // update a class schedule by management
        Route::put('/{id}', [App\Http\Controllers\ClassScheduleManagementController::class, 'update']);
    });

    // attendance api group
    Route::prefix('attendances')->group(function () {
        // manual attendance making by staff
        Route::post('/', [App\Http\Controllers\AttendanceManagementController::class, 'makeManualAttendance']);

        // get all attendances by student id
        Route::get('/', [App\Http\Controllers\AttendanceManagementController::class, 'getAttendances']);
    });

    // exam system api group
    Route::prefix('exams')->group(function () {
        // get all exams
        // Route::get('/', [App\Http\Controllers\ExamManagementController::class, 'index']);

        // get a exam
        // Route::get('/{id}', [App\Http\Controllers\ExamManagementController::class, 'show']);

        // create a exam
        // Route::post('/', [App\Http\Controllers\ExamManagementController::class, 'store']);

        // update a exam
        // Route::put('/{id}', [App\Http\Controllers\ExamManagementController::class, 'update']);

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
    // get all class enrollments by student id
    Route::get('/students/{student_id}', [App\Http\Controllers\ClassEnrollmentController::class, 'index']);

    // confirm enrollment by token
    Route::post('/confirm', [App\Http\Controllers\ClassEnrollmentController::class, 'confirmEnrollment']);
});

// class schedule api group
Route::prefix('class-schedules')->group(function () {
    Route::get('/classes/{class_id?}', [App\Http\Controllers\ClassScheduleController::class, 'index']);

    Route::get('/{id}', [App\Http\Controllers\ClassScheduleController::class, 'show']);
});

// attendance api group
Route::prefix('attendances')->group(function () {
    // make attendance
    Route::post('/students/{student_id}', [App\Http\Controllers\AttendanceController::class, 'makeAttendance']);

    // get all attendances by student id
    Route::get('/students/{student_id}', [App\Http\Controllers\AttendanceController::class, 'getAttendancesByStudentId']);
});

// exam system api group
Route::prefix('exams')->group(function () {
    // get all exams
    // Route::get('classes/{class_id?}', [App\Http\Controllers\ExamController::class, 'index']);

    // get a exam
    // Route::get('{id}', [App\Http\Controllers\ExamController::class, 'show']);
});

// exam question api group
Route::prefix('exam-questions')->group(function () {

});
