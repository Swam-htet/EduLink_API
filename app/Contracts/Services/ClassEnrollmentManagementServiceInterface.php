<?php

namespace App\Contracts\Services;

use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
     * Enroll students to class
     *
     * @param array $data
     * @return Collection
     */
    public function enrollStudents(array $data): Collection;

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

    /**
     * Get completed students by class ID
     *
     * @param int $classId
     * @return Collection
     */
    public function getCompletelyEnrolledStudentsByClassId(int $classId): Collection;
}
