<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\TenantResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Mail\Student\RegistrationPendingMail;
use App\Mail\Student\ForgotPasswordOtpMail;
use App\Mail\Student\PasswordChangeOtpMail;
use App\Mail\Student\PasswordChangeSuccessMail;
use App\Mail\Student\RegistrationApprovedMail;
use App\Mail\Student\RegistrationRejectedMail;

// test routes
Route::group(['prefix' => 'test'], function () {
    Route::get('/', function (Request $request) {
        return response()->json(['message' => 'Hello, World!', 'tenant' => new TenantResource($request->attributes->get('tenant'))]);
    });

    // test mail with queue
    Route::post('/mail', function (Request $request) {
        $mailTypes = [
            'registration_pending' => [
                'mailable' => RegistrationPendingMail::class,
                'data' => [
                    'name' => 'Test Student',
                    'email' => 'test@test.com',
                    'student_id' => 'STU001'
                ]
            ],
            'forgot_password_otp' => [
                'mailable' => ForgotPasswordOtpMail::class,
                'data' => [
                    'name' => 'Test Student',
                    'email' => 'test@test.com',
                    'otp' => '123456',
                    'expires_in' => '10 minutes'
                ]
            ],
            'password_change_otp' => [
                'mailable' => PasswordChangeOtpMail::class,
                'data' => [
                    'name' => 'Test Student',
                    'email' => 'test@test.com',
                    'otp' => '123456',
                    'expires_in' => '10 minutes'
                ]
            ],
            'password_change_success' => [
                'mailable' => PasswordChangeSuccessMail::class,
                'data' => [
                    'name' => 'Test Student',
                    'email' => 'test@test.com'
                ]
            ],
            'registration_approved' => [
                'mailable' => RegistrationApprovedMail::class,
                'data' => [
                    'name' => 'Test Student',
                    'email' => 'test@test.com',
                    'student_id' => 'STU001',
                    'login_url' => url('/login')
                ]
            ],
            'registration_rejected' => [
                'mailable' => RegistrationRejectedMail::class,
                'data' => [
                    'name' => 'Test Student',
                    'email' => 'test@test.com',
                    'reason' => 'Invalid documentation provided'
                ]
            ]
        ];

        $results = [];

        foreach ($mailTypes as $type => $config) {
            try {
                $mailable = new $config['mailable']($config['data']);
                Mail::to($config['data']['email'])->send($mailable);

                $results[$type] = [
                    'status' => 'success',
                    'message' => ucfirst(str_replace('_', ' ', $type)) . ' mail sent successfully'
                ];
            } catch (\Exception $e) {
                $results[$type] = [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'message' => 'Mail sending process completed',
            'results' => $results
        ]);
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
    // Route::put('/update-profile', [App\Http\Controllers\Auth\StaffController::class, 'updateProfile']);
});

// management api group with staff guard middleware
Route::middleware('auth:staff')->prefix('management')->group(function () {
    Route::prefix('student')->group(function () {
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
        // Route::post('/{id}/reset-password', [App\Http\Controllers\StaffManagementController::class, 'resetPassword']);
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
    Route::prefix('subject')->group(function () {
        // Route::get('/', [App\Http\Controllers\SubjectManagementController::class, 'index']);
        // Route::get('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'show']);
        // Route::post('/', [App\Http\Controllers\SubjectManagementController::class, 'store']);
        // Route::put('/{id}', [App\Http\Controllers\SubjectManagementController::class, 'update']);
    });

    // class api group
    Route::prefix('class')->group(function () {
        // Route::get('/', [App\Http\Controllers\ClassManagementController::class, 'index']);
        // Route::get('/{id}', [App\Http\Controllers\ClassManagementController::class, 'show']);
        // Route::post('/', [App\Http\Controllers\ClassManagementController::class, 'store']);
        // Route::put('/{id}', [App\Http\Controllers\ClassManagementController::class, 'update']);
    });

    // enroll student to class
    Route::prefix('enroll')->group(function () {
        // Route::post('/', [App\Http\Controllers\EnrollmentController::class, 'enrollStudent']);

        // get all enrollments by class id
        // Route::get('/class/{id}', [App\Http\Controllers\EnrollmentController::class, 'getEnrollmentsByClassId']);
    });

    // class schedule api group
    Route::prefix('class-schedule')->group(function () {
        // Route::get('/', [App\Http\Controllers\ClassScheduleManagementController::class, 'index']);
        // Route::get('/{id}', [App\Http\Controllers\ClassScheduleManagementController::class, 'show']);
        // Route::post('/', [App\Http\Controllers\ClassScheduleManagementController::class, 'store']);
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
Route::prefix('subject')->group(function () {
    // Route::get('/', [App\Http\Controllers\SubjectController::class, 'index']);
    // Route::get('/{id}', [App\Http\Controllers\SubjectController::class, 'show']);
});

// class api group
Route::prefix('class')->group(function () {
    // Route::get('/', [App\Http\Controllers\ClassController::class, 'index']);
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
