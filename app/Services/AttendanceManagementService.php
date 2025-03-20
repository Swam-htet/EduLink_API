<?php

namespace App\Services;

use App\Contracts\Services\AttendanceManagementServiceInterface;
use App\Contracts\Repositories\AttendanceRepositoryInterface;
use App\Models\Tenants\Attendance;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;
use App\Contracts\Repositories\StudentClassEnrollmentRepositoryInterface;
use App\Contracts\Repositories\ClassScheduleRepositoryInterface;

class AttendanceManagementService implements AttendanceManagementServiceInterface
{
    protected $attendanceRepository;
    protected $enrollmentRepository;
    protected $scheduleRepository;

    public function __construct(AttendanceRepositoryInterface $attendanceRepository, StudentClassEnrollmentRepositoryInterface $enrollmentRepository, ClassScheduleRepositoryInterface $scheduleRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function makeManualAttendance(array $data): Attendance
    {
        // check student is enrolled in the class schedule's class id in class_enrollments table
        $enrollment = $this->enrollmentRepository->getCompletedEnrollmentByStudentIdAndClassId($data['student_id'], $data['class_schedule_id']);

        if (!$enrollment) {
            throw ValidationException::withMessages([
                'class_schedule_id' => 'Student is not enrolled in this class'
            ]);
        }

        // Get class schedule using repository
        $schedule = $this->scheduleRepository->findById($data['class_schedule_id']);

        if (!$schedule) {
            throw ValidationException::withMessages([
                'class_schedule_id' => 'Class schedule not found'
            ]);
        }

        // Check if class schedule is active
        if ($schedule->status !== 'active') {
            throw ValidationException::withMessages([
                'class_schedule_id' => 'Class schedule is not active'
            ]);
        }

        // Check if attendance already exists using repository
        $existingAttendance = $this->attendanceRepository->findExistingAttendance(
            $data['student_id'],
            $data['class_schedule_id']
        );

        if ($existingAttendance) {
            throw ValidationException::withMessages([
                'class_schedule_id' => 'Attendance already exists'
            ]);
        }

        // Create attendance data
        $attendanceData = [
            'student_id' => $data['student_id'],
            'class_schedule_id' => $data['class_schedule_id'],
            'status' => $data['status'],
            'remarks' => $data['remarks'] ?? null
        ];

        return $this->attendanceRepository->create($attendanceData);
    }

    public function getFilteredAttendances(array $filters): LengthAwarePaginator
    {
        return $this->attendanceRepository->getPaginatedAttendances($filters);
    }
}