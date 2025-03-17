<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Staff;

interface StaffAuthServiceInterface
{
    /**
     * Authenticate staff and generate token
     *
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): array;

    /**
     * Logout staff
     *
     * @param Staff $staff
     * @return bool
     */
    public function logout(Staff $staff): bool;
}
