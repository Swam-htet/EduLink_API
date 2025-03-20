<?php

namespace App\Contracts\Services;

use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Pagination\LengthAwarePaginator;

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

    /**
     * Get enrollments by student ID with filters
     *
     * @param int $studentId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getEnrollmentsByStudentId(int $studentId, array $filters): LengthAwarePaginator;
}
