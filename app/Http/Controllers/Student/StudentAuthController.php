<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentAuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentAuthController extends Controller
{
    /**
     * @var StudentAuthServiceInterface
     */
    protected $studentAuthService;

    /**
     * StudentAuthController constructor.
     *
     * @param StudentAuthServiceInterface $studentAuthService
     */
    public function __construct(StudentAuthServiceInterface $studentAuthService)
    {
        $this->studentAuthService = $studentAuthService;
    }

    /**
     * Login a student
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->studentAuthService->login($request);

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully',
            'data' => $result
        ]);
    }

    /**
     * Logout a student
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->studentAuthService->logout($request);

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get student profile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        $student = $this->studentAuthService->getProfile($request);

        return response()->json([
            'success' => true,
            'data' => [
                'student' => $student
            ]
        ]);
    }
}
