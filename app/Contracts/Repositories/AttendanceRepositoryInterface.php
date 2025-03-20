<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Attendance;
use App\Models\Tenants\ClassSchedule;
use Illuminate\Pagination\LengthAwarePaginator;

interface AttendanceRepositoryInterface
{
    /**
     * Create new attendance
     *
     * @param array $data
     * @return Attendance
     */
    public function create(array $data): Attendance;

    /**
     * Get paginated attendances by student ID
     *
     * @param int $studentId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedAttendancesByStudentId(int $studentId, array $filters): LengthAwarePaginator;

    /**
     * Find existing attendance
     *
     * @param int $studentId
     * @param int $classScheduleId
     * @return Attendance|null
     */
    public function findExistingAttendance(int $studentId, int $classScheduleId): ?Attendance;

    /**
     * Get paginated attendances with filters
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedAttendances(array $filters): LengthAwarePaginator;

    /**
     * Check if student is enrolled in class
     *
     * @param int $studentId
     * @param int $classId
     * @return bool
     */
    public function isStudentEnrolledInClass(int $studentId, int $classId): bool;
}
