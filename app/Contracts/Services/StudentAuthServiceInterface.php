<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Student;

interface StudentAuthServiceInterface
{
    /**
     * Login student and generate token
     *
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): array;

    /**
     * Logout student and revoke tokens
     *
     * @param Student $student
     * @return bool
     */
    public function logout(Student $student): bool;
}