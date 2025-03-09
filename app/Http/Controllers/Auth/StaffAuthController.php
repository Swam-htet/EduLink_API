<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\StaffAuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\LoginRequest;
use App\Http\Requests\Staff\RegisterRequest;
use Illuminate\Http\Request;

class StaffAuthController extends Controller
{
    protected $staffAuthService;

    public function __construct(StaffAuthServiceInterface $staffAuthService)
    {
        $this->staffAuthService = $staffAuthService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->staffAuthService->register($request);

        return response()->json([
            'success' => true,
            'message' => 'Staff registered successfully',
            'data' => $result
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->staffAuthService->login($request);

        return response()->json([
            'success' => true,
            'message' => 'Logged in successfully',
            'data' => $result
        ]);
    }

    public function logout(Request $request)
    {
        $this->staffAuthService->logout($request);

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function profile(Request $request)
    {
        $staff = $this->staffAuthService->getProfile($request);

        return response()->json([
            'success' => true,
            'data' => [
                'staff' => $staff
            ]
        ]);
    }
}
