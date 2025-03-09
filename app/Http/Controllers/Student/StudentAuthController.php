<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentAuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentAuthController extends Controller
{

    protected $studentAuthService;

    public function __construct(StudentAuthServiceInterface $studentAuthService)
    {
        $this->studentAuthService = $studentAuthService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->studentAuthService->login($request);

        return response()->json([
            'success' => true,
            'message' => trans('messages.success.logged_in'),
            'data' => $result
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->studentAuthService->logout($request);

        return response()->json([
            'success' => true,
            'message' => trans('messages.success.logged_out')
        ]);
    }

    public function profile(Request $request): JsonResponse
    {
        $student = $this->studentAuthService->getProfile($request);

        return response()->json([
            'success' => true,
            'message' => trans('messages.success.profile_fetched'),
            'data' => [
                'student' => $student
            ]
        ]);
    }
}
