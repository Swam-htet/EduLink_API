<?php

namespace App\Repositories;

use App\Contracts\Repositories\StudentClassEnrollmentRepositoryInterface;
use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentClassEnrollmentRepository implements StudentClassEnrollmentRepositoryInterface
{
    protected $model;

    public function __construct(StudentClassEnrollment $model)
    {
        $this->model = $model;
    }

    public function create(array $data): StudentClassEnrollment
    {
        $data['enrolled_at'] = now();
        $enrollment = $this->model->create($data);
        return $enrollment->load('student', 'class');
    }

    public function isStudentEnrolled(int $studentId, int $classId): bool
    {
        return $this->model->where('student_id', $studentId)
            ->where('class_id', $classId)
            ->exists();
    }

    public function getEnrollmentsByClassId(int $classId): Collection
    {
        return $this->model->with(['student'])
            ->where('class_id', $classId)
            ->get();
    }

    public function getCompletedEnrollmentsByStudentId(int $studentId): Collection
    {
        return $this->model->with(['student', 'class'])
            ->where('student_id', $studentId)
            ->where('status', 'completed')
            ->get();
    }

    public function getCompletedEnrollmentsByClassId(int $classId): Collection
    {
        return $this->model->with(['student', 'class'])
            ->where('class_id', $classId)
            ->where('status', 'completed')
            ->get();
    }

    public function getEnrollmentsByStudentId(int $studentId): Collection
    {
        return $this->model->with(['class'])
            ->where('student_id', $studentId)
            ->get();
    }

    public function getPaginatedEnrollments(array $filters): LengthAwarePaginator
    {
        $query = $this->model->with(['student', 'class']);

        // Basic Filters
        if (isset($filters['student_id'])) {
            $query->where('student_id', $filters['student_id']);
        }

        if (isset($filters['class_id'])) {
            $query->where('class_id', $filters['class_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Date Range Filter
        if (isset($filters['enrolled_at'])) {
            $query->whereBetween('enrolled_at', [
                $filters['enrolled_at']['start'],
                $filters['enrolled_at']['end']
            ]);
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate($filters['per_page'] ?? 15);
    }

    /**
     * Find enrollment by ID
     *
     * @param int $id
     * @return StudentClassEnrollment|null
     */
    public function findById(int $id): ?StudentClassEnrollment
    {
        return $this->model->with(['student', 'class'])->find($id);
    }

    /**
     * Get paginated enrollments by student ID with filters
     *
     * @param int $studentId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedEnrollmentsByStudentId(int $studentId, array $filters): LengthAwarePaginator
    {
        $query = $this->model->with(['student', 'class'])
            ->where('student_id', $studentId);

        // Apply class filter
        if (isset($filters['class_id'])) {
            $query->where('class_id', $filters['class_id']);
        }

        // Apply status filter
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Apply enrolled date range filter
        if (isset($filters['enrolled_date'])) {
            $query->whereBetween('enrolled_at', [
                $filters['enrolled_date']['start'],
                $filters['enrolled_date']['end']
            ]);
        }

        return $query->latest('enrolled_at')
            ->paginate(15);
    }

    public function update(int $id, array $data): StudentClassEnrollment
    {
        $enrollment = $this->findById($id);
        $enrollment->update($data);
        return $enrollment->fresh();
    }

    /**
     * Update enrollment status
     *
     * @param StudentClassEnrollment $enrollment
     * @param string $status
     * @return StudentClassEnrollment
     */
    public function updateStatus(StudentClassEnrollment $enrollment, string $status): StudentClassEnrollment
    {
        $enrollment->status = $status;
        $enrollment->save();

        return $enrollment->fresh();
    }
}
