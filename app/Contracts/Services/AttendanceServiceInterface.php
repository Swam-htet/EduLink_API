<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Attendance;

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
}
