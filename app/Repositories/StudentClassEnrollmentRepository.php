<?php

namespace App\Repositories;

use App\Contracts\Repositories\StudentClassEnrollmentRepositoryInterface;
use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Database\Eloquent\Collection;

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
        return $this->model->with(['student', 'class'])
            ->where('class_id', $classId)
            ->get();
    }

    public function getEnrollmentsByStudentId(int $studentId): Collection
    {
        return $this->model->with(['student', 'class'])
            ->where('student_id', $studentId)
            ->get();
    }
}
