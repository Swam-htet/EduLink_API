<?php

namespace App\Services;

use App\Contracts\Services\StaffAuthServiceInterface;
use App\Http\Requests\Staff\LoginRequest;
use App\Http\Requests\Staff\RegisterRequest;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StaffAuthService implements StaffAuthServiceInterface
{
    /**
     * Register a new staff member
     *
     * @param RegisterRequest $request
     * @return array
     */
    public function register(RegisterRequest $request): array
    {
        $validatedData = $request->validated();

        // Generate a unique staff ID
        $validatedData['staff_id'] = 'STF' . str_pad(Staff::count() + 1, 4, '0', STR_PAD_LEFT);

        // Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create the staff
        $staff = Staff::create($validatedData);

        // Generate token with staff and admin scopes
        $token = $staff->createToken('Staff Access Token', ['staff', 'admin'])->accessToken;

        return [
            'token' => $token,
            'staff' => $staff
        ];
    }

    /**
     * Login a staff member
     *
     * @param LoginRequest $request
     * @return array
     */
    public function login(LoginRequest $request): array
    {
        $staff = Staff::where('email', $request->email)->first();

        if (!$staff || !Hash::check($request->password, $staff->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Generate token with staff and admin scopes
        $token = $staff->createToken('Staff Access Token', ['staff', 'admin'])->accessToken;

        return [
            'token' => $token,
            'staff' => $staff
        ];
    }

    /**
     * Logout a staff member
     *
     * @param Request $request
     * @return bool
     */
    public function logout(Request $request): bool
    {
        return $request->user()->token()->revoke();
    }

    /**
     * Get staff profile
     *
     * @param Request $request
     * @return Staff
     */
    public function getProfile(Request $request): Staff
    {
        return $request->user();
    }
}
