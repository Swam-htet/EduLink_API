<?php

namespace App\Contracts\Services;

use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClassEnrollmentManagementServiceInterface
{

    /**
     * Get paginated enrollments
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedEnrollments(array $filters): LengthAwarePaginator;

    /**
     * Enroll student to class
     *
     * @param array $data
     * @return StudentClassEnrollment
     */
    public function enrollStudent(array $data): StudentClassEnrollment;

    /**
     * Update enrollment
     *
     * @param array $data
     * @return StudentClassEnrollment
     */
    public function update(array $data): StudentClassEnrollment;

    /**
     * Send enrollment email
     *
     * @param array $data
     * @return void
     */
    public function sendManualEnrollmentEmail(array $data): void;
}
