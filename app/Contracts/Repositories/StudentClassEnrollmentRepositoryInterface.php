<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Database\Eloquent\Collection;

interface StudentClassEnrollmentRepositoryInterface
{
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
     * Get enrollments by class ID
     *
     * @param int $classId
     * @return Collection
     */
    public function getEnrollmentsByClassId(int $classId): Collection;

    /**
     * Get enrollments by student ID
     *
     * @param int $studentId
     * @return Collection
     */
    public function getEnrollmentsByStudentId(int $studentId): Collection;
}
