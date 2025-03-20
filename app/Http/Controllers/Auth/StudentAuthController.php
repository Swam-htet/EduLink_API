<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentLoginRequest;
use App\Contracts\Services\StudentAuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Response;
class StudentAuthController extends Controller
{
    protected $authService;

    public function __construct(StudentAuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle student login
     *
     * @param StudentLoginRequest $request
     * @return JsonResponse
     */
    public function login(StudentLoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());

        return response()->json([
            'message' => 'Login successful.',
            'data' => [
                'student' => new StudentResource($result['student']),
                'token' => $result['token'],
                'token_type' => 'Bearer',
                'expires_at' => $result['expires_at']
            ],
        ], Response::HTTP_OK);

    }

    /**
     * Handle student logout
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $student = $request->user();

        $this->authService->logout($student);

        return response()->json([
            'message' => 'Logged out successfully.'
        ], Response::HTTP_OK);
    }

    /**
     * Get authenticated student profile
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getProfile(Request $request): JsonResponse
    {
        $student = $request->user();

        return response()->json([
            'data' => new StudentResource($student)
        ], Response::HTTP_OK);
    }
}
