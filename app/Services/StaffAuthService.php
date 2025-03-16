<?php

namespace App\Services;

use App\Contracts\Services\StaffAuthServiceInterface;
use App\Models\Tenants\Staff;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class StaffAuthService implements StaffAuthServiceInterface
{
    /**
     * Authenticate staff and generate token
     *
     * @param array $credentials
     * @return array
     * @throws AuthenticationException
     */
    public function login(array $credentials): array
    {
        // Find user by email
        $staff = Staff::where('email', $credentials['email'])->first();

        // Check if user exists and password is correct
        if (!$staff || !Hash::check($credentials['password'], $staff->password)) {
            throw new UnauthorizedHttpException('', 'Invalid credentials');
        }

        // Generate Passport token
        $tokenResult = $staff->createToken('staff-token', ['staff']);

        return [
                'staff' => $staff,
                'token' => $tokenResult->accessToken,
                'expires_at' => $tokenResult->token->expires_at,
                'token_type' => 'Bearer'
        ];
    }

    /**
     * Logout staff
     *
     * @param Staff $staff
     * @return void
     */
    public function logout(Staff $staff): void
    {
        $staff->token()->revoke();
    }
}
