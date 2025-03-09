<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\StudentAuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\LoginRequest;
use App\Http\Requests\Student\RegisterRequest;
use Illuminate\Http\Request;

class StudentAuthController extends Controller
{
    protected $studentAuthService;

    public function __construct(StudentAuthServiceInterface $studentAuthService)
    {
        $this->studentAuthService = $studentAuthService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->studentAuthService->register($request);

        return response()->json([
            'success' => true,
            'message' => 'Student registered successfully',
            'data' => $result
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->studentAuthService->login($request);

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully',
            'data' => $result
        ]);
    }

    public function logout(Request $request)
    {
        $this->studentAuthService->logout($request);

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function profile(Request $request)
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
