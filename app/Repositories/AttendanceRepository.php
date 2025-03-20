<?php

namespace App\Repositories;

use App\Contracts\Repositories\AttendanceRepositoryInterface;
use App\Models\Tenants\Attendance;
use App\Models\Tenants\ClassSchedule;
use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Pagination\LengthAwarePaginator;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    protected $model;
    protected $scheduleModel;

    public function __construct(Attendance $model, ClassSchedule $scheduleModel)
    {
        $this->model = $model;
        $this->scheduleModel = $scheduleModel;
    }

    /**
     * Create new attendance
     *
     * @param array $data
     * @return Attendance
     */
    public function create(array $data): Attendance
    {
        return $this->model->create($data);
    }

    /**
     * Get paginated attendances by student ID
     *
     * @param int $studentId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedAttendancesByStudentId(int $studentId, array $filters): LengthAwarePaginator
    {
        $query = $this->model->with(['classSchedule.class', 'student'])
            ->where('student_id', $studentId);

        // Filter by class schedule
        if (isset($filters['class_schedule_id'])) {
            $query->where('class_schedule_id', $filters['class_schedule_id']);
        }

        // Filter by status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by date range
        if (isset($filters['date_range'])) {
            $query->whereHas('classSchedule', function ($query) use ($filters) {
                $query->whereBetween('date', [
                    $filters['date_range']['start'],
                    $filters['date_range']['end']
                ]);
            });
        }

        return $query->latest()
            ->paginate($filters['per_page'] ?? 15);
    }

    public function findExistingAttendance(int $studentId, int $classScheduleId): ?Attendance
    {
        return $this->model->where('student_id', $studentId)
            ->where('class_schedule_id', $classScheduleId)
            ->first();
    }

    public function getPaginatedAttendances(array $filters): LengthAwarePaginator
    {
        $query = $this->model->with(['student', 'classSchedule.class']);

        // Filter by student
        if (isset($filters['student_id'])) {
            $query->where('student_id', $filters['student_id']);
        }

        // Filter by class schedule
        if (isset($filters['class_schedule_id'])) {
            $query->where('class_schedule_id', $filters['class_schedule_id']);
        }

        // Filter by class
        if (isset($filters['class_id'])) {
            $query->whereHas('classSchedule', function ($query) use ($filters) {
                $query->where('class_id', $filters['class_id']);
            });
        }

        // Filter by status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by date range
        if (isset($filters['date_range'])) {
            $query->whereHas('classSchedule', function ($query) use ($filters) {
                $query->whereBetween('date', [
                    $filters['date_range']['start'],
                    $filters['date_range']['end']
                ]);
            });
        }

        return $query->latest()
            ->paginate($filters['per_page'] ?? 15);
    }

    public function isStudentEnrolledInClass(int $studentId, int $classId): bool
    {
        return StudentClassEnrollment::where('student_id', $studentId)
            ->where('class_id', $classId)
            ->where('status', 'enrolled')
            ->exists();
    }
}
