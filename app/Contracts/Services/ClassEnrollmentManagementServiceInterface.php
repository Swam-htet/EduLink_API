<?php

namespace App\Contracts\Services;

use App\Models\Tenants\StudentClassEnrollment;

interface ClassEnrollmentManagementServiceInterface
{
    /**
     * Enroll student to class
     *
     * @param array $data
     * @return StudentClassEnrollment
     */
    public function enrollStudent(array $data): StudentClassEnrollment;
}
