<?php

namespace App\Contracts\Services;

use App\Models\Tenants\StudentClassEnrollment;

interface ClassEnrollmentServiceInterface
{
    /**
     * Confirm enrollment using token
     *
     * @param string $token
     * @return StudentClassEnrollment
     * @throws \Exception
     */
    public function confirmEnrollment(string $token): StudentClassEnrollment;
}
