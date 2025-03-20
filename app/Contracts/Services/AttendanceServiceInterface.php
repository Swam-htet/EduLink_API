<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Attendance;
use Illuminate\Pagination\LengthAwarePaginator;

interface AttendanceServiceInterface
{
    /**
     * Make attendance for student
     *
     * @param int $studentId
     * @param array $data
     * @return Attendance
     */
    public function makeAttendance(int $studentId, array $data): Attendance;

    /**
     * Get paginated attendances by student ID
     *
     * @param int $studentId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAttendancesByStudentId(int $studentId, array $filters): LengthAwarePaginator;
}
