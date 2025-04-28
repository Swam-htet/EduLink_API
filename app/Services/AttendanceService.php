<?php

namespace App\Services;

use App\Contracts\Services\AttendanceServiceInterface;
use App\Contracts\Repositories\AttendanceRepositoryInterface;
use App\Models\Tenants\Attendance;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use App\Contracts\Repositories\ClassScheduleRepositoryInterface;
use App\Contracts\Repositories\StudentClassEnrollmentRepositoryInterface;
class AttendanceService implements AttendanceServiceInterface
{
    protected $attendanceRepository;
    protected $scheduleRepository;
    protected $enrollmentRepository;

    public function __construct(AttendanceRepositoryInterface $attendanceRepository, ClassScheduleRepositoryInterface $scheduleRepository, StudentClassEnrollmentRepositoryInterface $enrollmentRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->enrollmentRepository = $enrollmentRepository;
    }

    /**
     * Make attendance for student
     *
     * @param int $studentId
     * @param array $data
     * @return Attendance
     */
    public function makeAttendance(int $studentId, array $data): Attendance
    {
        // Get class schedule using repository
        $schedule = $this->scheduleRepository->findById($data['class_schedule_id']);

        // if (!$schedule) {
        //     throw ValidationException::withMessages([
        //         'class_schedule_id' => 'Class schedule not found'
        //     ]);
        // }

        // // Check if class schedule is cancelled or completed
        // if ($schedule->status === 'cancelled' || $schedule->status === 'completed') {
        //     throw ValidationException::withMessages([
        //         'class_schedule_id' => 'Class schedule is cancelled or completed'
        //     ]);
        // }

        // // Check if it's too early to make attendance (before class starts)
        // if ($schedule->start_time > now()) {
        //     throw ValidationException::withMessages([
        //         'class_schedule_id' => 'Too early to make attendance'
        //     ]);
        // }

        // // Check if it's too late to make attendance (after class end time)
        // if ($schedule->end_time < now()) {
        //     throw ValidationException::withMessages([
        //         'class_schedule_id' => 'Too late to make attendance'
        //     ]);
        // }

        // // Check if attendance already exists using repository
        // $existingAttendance = $this->attendanceRepository->findExistingAttendance(
        //     $studentId,
        //     $data['class_schedule_id']
        // );

        // if ($existingAttendance) {
        //     throw ValidationException::withMessages([
        //         'class_schedule_id' => 'Attendance already exists'
        //     ]);
        // }

        $time_in = now();

        $status = 'present';

        if ($time_in > $schedule->start_time->addMinutes($schedule->late_mins)) {
            $status = 'late';
        }

        // Create attendance data
        $attendanceData = [
            'student_id' => $studentId,
            'class_schedule_id' => $data['class_schedule_id'],
            'status' => $status,
            'time_in' => $time_in,
            'remarks' => $data['remarks'] ?? null
        ];

        return $this->attendanceRepository->create($attendanceData);
    }
}
