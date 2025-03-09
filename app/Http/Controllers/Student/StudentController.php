<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentRegistrationServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\RegisterRequest;
use Illuminate\Http\JsonResponse;
use App\Contracts\Services\TokenServiceInterface;

class StudentController extends Controller
{

    protected $studentRegistrationService;

    protected $tokenService;

    public function __construct(StudentRegistrationServiceInterface $studentRegistrationService, TokenServiceInterface $tokenService)
    {
        $this->studentRegistrationService = $studentRegistrationService;
        $this->tokenService = $tokenService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $student = $this->studentRegistrationService->registerStudent($request);

        $token = $this->tokenService->createStudentToken($student);

        return response()->json([
            'success' => true,
            'message' => trans('messages.success.student_registered'),
            'data' => [
                'token' => $token,
                'student' => $student
            ]
        ], 201);
    }
}
