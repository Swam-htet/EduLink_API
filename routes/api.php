<?php

use Illuminate\Support\Facades\Route;


// auth api group
Route::prefix('auth')->group(function () {
    Route::group(['prefix' => 'student'], function () {
        // login for student - done
        Route::post('/login', [App\Http\Controllers\Auth\StudentAuthController::class, 'login']);
        Route::group(['middleware' => 'auth:student'], function () {
            // logout for student - done
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
        // login for staff - done
        Route::post('/login', [App\Http\Controllers\Auth\StaffAuthController::class, 'login']);

        Route::group(['middleware' => 'auth:staff'], function () {
            // logout for staff - done
            Route::post('/logout', [App\Http\Controllers\Auth\StaffAuthController::class, 'logout']);

            // get staff profile
            Route::get('/profile', [App\Http\Controllers\Auth\StaffAuthController::class, 'getProfile']);
        });
    });
});


Route::prefix('students')->group(function () {
    // register for student - done
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
Route::prefix('management')->group(function () {
    Route::prefix('students')->group(function () {
        // get all students for management - done
        Route::get('/', [App\Http\Controllers\StudentManagementController::class, 'index']);

        // get a student for management - done
        Route::get('/{id}', [App\Http\Controllers\StudentManagementController::class, 'show']);

        // approve student registration for management - done
        Route::post('/approve-registration', [App\Http\Controllers\StudentManagementController::class, 'approveRegistration']);

        // reject student registration for management - done
        Route::post('/reject-registration', [App\Http\Controllers\StudentManagementController::class, 'rejectRegistration']);


    });

    // staff api group
    Route::prefix('staff')->group(function () {

        // get all staffs for management - done
        Route::get('/', [App\Http\Controllers\StaffManagementController::class, 'index']);

        // get a staff for management - done
        Route::get('/{id}', [App\Http\Controllers\StaffManagementController::class, 'show']);

        // create a staff by management - done
        Route::post('/', [App\Http\Controllers\StaffManagementController::class, 'create']);

        // // update staff
        // Route::put('/{id}', [App\Http\Controllers\StaffManagementController::class, 'update']);

        // // reset staff password
        // Route::get('/{id}/reset-password', [App\Http\Controllers\StaffManagementController::class, 'resetPassword']);
    });

    // course api group
    Route::prefix('courses')->group(function () {
        // get all courses for management - done
        Route::get('/', [App\Http\Controllers\CourseManagementController::class, 'index']);

        // get a course for management - done
        Route::get('/{id}', [App\Http\Controllers\CourseManagementController::class, 'show']);

        // create a course by management - done
        Route::post('/', [App\Http\Controllers\CourseManagementController::class, 'store']);

        // update a course by management - done
        Route::put('/{id}', [App\Http\Controllers\CourseManagementController::class, 'update']);

        // delete a course by management - done
        Route::delete('/{id}', [App\Http\Controllers\CourseManagementController::class, 'destroy']);
    });

    // subject api group
    Route::prefix('subjects')->group(function () {
        // get all subjects for management
        Route::get('/', [App\Http\Controllers\SubjectManagementController::class, 'index']);

        // get a subject for management - done
        Route::get('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'show']);

        // create a subject by management - done
        Route::post('/', [App\Http\Controllers\SubjectManagementController::class, 'store']);

        // update a subject by management - done
        Route::put('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'update']);

        // delete a subject by management - done
        Route::delete('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'destroy']);
    });

    // class api group
    Route::prefix('classes')->group(function () {
        // get all classes for management - done
        Route::get('/', [App\Http\Controllers\ClassManagementController::class, 'index']);

        // get all ongoing classes for management - done
        Route::get('/ongoing', [App\Http\Controllers\ClassManagementController::class, 'ongoingClasses']);

        // get a class for management - done
        Route::get('/{id}', [App\Http\Controllers\ClassManagementController::class, 'show']);

        // create a class by management - done
        Route::post('/', [App\Http\Controllers\ClassManagementController::class, 'store']);

        // update a class by management
        Route::put('/{id}', [App\Http\Controllers\ClassManagementController::class, 'update']);
    });

    // enroll student to class
    Route::prefix('class-enrollments')->group(function () {
        // get all class enrollments for management - done
        Route::get('/', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'index']);

        // update a class enrollment by management
        Route::put('/{id}', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'update']);

        // enroll student to class - done
        Route::post('/', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'enrollStudents']);

        // send manual enrollment email - done
        Route::post('/send-email', [App\Http\Controllers\ClassEnrollmentManagementController::class, 'sendManualEnrollmentEmail']);
    });

    // class schedule api group
    Route::prefix('class-schedules')->group(function () {
        // get all class schedules for management - done
        Route::get('/classes/{class_id?}', [App\Http\Controllers\ClassScheduleManagementController::class, 'index']);

        // create a class schedule by management - done
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
        // get all exams - done
        Route::get('/', [App\Http\Controllers\ExamManagementController::class, 'index']);

        // get a exam - done
        Route::get('/{id}', [App\Http\Controllers\ExamManagementController::class, 'show']);

        // create a exam - done
        Route::post('/', [App\Http\Controllers\ExamManagementController::class, 'store']);

        // update a exam
        Route::put('/{id}', [App\Http\Controllers\ExamManagementController::class, 'update']);

        // publish a exam
        Route::post('/{id}/publish', [App\Http\Controllers\ExamManagementController::class, 'publish']);

        // send manual publish exam mail
        Route::post('/{id}/send-publish-mail', [App\Http\Controllers\ExamManagementController::class, 'sendManualPublishExamMail']);

        // upload exam questions - done
        Route::post('/{exam_id}/upload-questions', [App\Http\Controllers\ExamManagementController::class, 'uploadQuestions']);

        // get exam results
        Route::get('/{exam_id}/results', [App\Http\Controllers\ExamManagementController::class, 'getExamResults']);

        // get a exam result
        Route::get('/{exam_id}/results/{result_id}/students/{student_id}', [App\Http\Controllers\ExamManagementController::class, 'getExamResult']);

        // manual grading exam result
        Route::post('/manual-grading', [App\Http\Controllers\ExamManagementController::class, 'manualGradingExamResult']);

        // send exam results to students
        Route::post('/{exam_id}/send-results', [App\Http\Controllers\ExamManagementController::class, 'sendExamResultsToStudents']);

    });

    // config api group
    Route::prefix('configs')->group(function () {
        Route::get('/', [App\Http\Controllers\TenantLandingController::class, 'getLandingData']);
        Route::get('/{key}', [App\Http\Controllers\TenantLandingController::class, 'getLandingDataByKey']);
        Route::post('/{key}', [App\Http\Controllers\TenantLandingController::class, 'setLandingData']);
    });


});

Route::middleware('auth:student')->prefix('student')->group(function () {

    Route::prefix('classes')->group(function () {
        Route::get('/', [App\Http\Controllers\ClassController::class, 'index']);
    });

    Route::prefix('courses')->group(function () {
        Route::get('/', [App\Http\Controllers\CourseController::class, 'index']);
    });

    Route::prefix('subjects')->group(function () {
        Route::get('/', [App\Http\Controllers\SubjectController::class, 'index']);
    });


    Route::prefix('class-enrollments')->group(function () {
        Route::get('/students/{student_id}', [App\Http\Controllers\ClassEnrollmentController::class, 'index']);

        // confirm enrollment by token
        Route::post('/confirm', [App\Http\Controllers\ClassEnrollmentController::class, 'confirmEnrollment']);
    });

    Route::prefix('class-schedules')->group(function () {
        Route::get('/classes/{class_id}', [App\Http\Controllers\ClassScheduleController::class, 'index']);

        Route::post('/{class_schedule_id}/attendance', [App\Http\Controllers\AttendanceController::class, 'makeAttendance']);
    });

    // exam system api group
    Route::prefix('exams')->group(function () {
        // get all exams
        Route::get('classes/{class_id?}', [App\Http\Controllers\ExamController::class, 'index']);

        // get a exam
        Route::get('{id}', [App\Http\Controllers\ExamController::class, 'show']);

        // submit exam
        Route::post('{id}/submit', [App\Http\Controllers\ExamController::class, 'submit']);

        // get exam result detail
        Route::get('{id}/result', [App\Http\Controllers\ExamController::class, 'getExamResult']);
    });
});

Route::get('/configs', [App\Http\Controllers\TenantLandingController::class, 'getLandingData']);
