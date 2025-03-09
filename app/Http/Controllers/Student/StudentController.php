<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentRegistrationServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\RegisterRequest;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    /**
     * @var StudentRegistrationServiceInterface
     */
    protected $studentRegistrationService;

    /**
     * @var TokenService
     */
    protected $tokenService;

    /**
     * StudentController constructor.
     *
     * @param StudentRegistrationServiceInterface $studentRegistrationService
     * @param TokenService $tokenService
     */
    public function __construct(
        StudentRegistrationServiceInterface $studentRegistrationService,
        TokenService $tokenService
    ) {
        $this->studentRegistrationService = $studentRegistrationService;
        $this->tokenService = $tokenService;
    }

    /**
     * Register a new student
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $student = $this->studentRegistrationService->registerStudent($request);

        // Generate token for auto login after registration
        $token = $this->tokenService->createStudentToken($student);

        return response()->json([
            'success' => true,
            'message' => 'Student registered successfully',
            'data' => [
                'token' => $token,
                'student' => $student
            ]
        ], 201);
    }
}
