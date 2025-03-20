<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Attendance;
use Illuminate\Pagination\LengthAwarePaginator;

interface AttendanceManagementServiceInterface
{
    /**
     * Make manual attendance for student
     *
     * @param array $data
     * @return Attendance
     */
    public function makeManualAttendance(array $data): Attendance;

    /**
     * Get filtered attendances
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getFilteredAttendances(array $filters): LengthAwarePaginator;
}
