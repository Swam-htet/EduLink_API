<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface StudentClassEnrollmentRepositoryInterface
{
    /**
     * Get paginated enrollments with filters
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedEnrollments(array $filters): LengthAwarePaginator;

    /**
     * Find enrollment by ID
     *
     * @param int $id
     * @return StudentClassEnrollment|null
     */
    public function findById(int $id): ?StudentClassEnrollment;

    /**
     * Update enrollment
     *
     * @param int $id
     * @param array $data
     * @return StudentClassEnrollment
     */
    public function update(int $id, array $data): StudentClassEnrollment;

    /**
     * Get enrollments by student ID
     *
     * @param int $studentId
     * @return Collection
     */
    public function getEnrollmentsByStudentId(int $studentId): Collection;

    /**
     * Get enrollments by class ID
     *
     * @param int $classId
     * @return Collection
     */
    public function getEnrollmentsByClassId(int $classId): Collection;

    /**
     * Create new enrollment
     *
     * @param array $data
     * @return StudentClassEnrollment
     */
    public function create(array $data): StudentClassEnrollment;

    /**
     * Check if student is already enrolled in class
     *
     * @param int $studentId
     * @param int $classId
     * @return bool
     */
    public function isStudentEnrolled(int $studentId, int $classId): bool;

    /**
     * Get completed enrollments by student ID
     *
     * @param int $studentId
     * @return Collection
     */
    public function getCompletedEnrollmentsByStudentId(int $studentId): Collection;

    /**
     * Get completed enrollments by class ID
     *
     * @param int $classId
     * @return Collection
     */
    public function getCompletedEnrollmentsByClassId(int $classId): Collection;

    /**
     * Get paginated enrollments by student ID with filters
     *
     * @param int $studentId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedEnrollmentsByStudentId(int $studentId, array $filters): LengthAwarePaginator;

    /**
     * Update enrollment status
     *
     * @param StudentClassEnrollment $enrollment
     * @param string $status
     * @return StudentClassEnrollment
     */
    public function updateStatus(StudentClassEnrollment $enrollment, string $status): StudentClassEnrollment;
}
