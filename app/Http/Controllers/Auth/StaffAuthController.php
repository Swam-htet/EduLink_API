<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StaffLoginRequest;
use App\Contracts\Services\StaffAuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
class StaffAuthController extends Controller
{
    protected $staffAuthService;

    public function __construct(StaffAuthServiceInterface $staffAuthService)
    {
        $this->staffAuthService = $staffAuthService;
    }

    /**
     * Login staff
     *
     * @param StaffLoginRequest $request
     * @return JsonResponse
     */
    public function login(StaffLoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $result = $this->staffAuthService->login($credentials);

        return response()->json([
            'message' => 'Login successful',
            'data' => $result
        ], Response::HTTP_OK);
    }

    /**
     * Logout staff
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->staffAuthService->logout($request->user());

        return response()->json([
            'message' => 'Logout successful'
        ], Response::HTTP_OK);
    }

    /**
     * Get staff profile
     *
     * @return JsonResponse
     */
    public function getProfile(Request $request): JsonResponse
    {
        $staff = $request->user();

        return response()->json([
            'message' => 'Profile retrieved successfully',
            'data' => $staff
        ], Response::HTTP_OK);
    }
}
