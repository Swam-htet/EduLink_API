<?php

namespace App\Repositories;

use App\Models\Tenants\Student;
use App\Contracts\Repositories\StudentRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    /**
     * Get paginated students with filters
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedStudents(array $filters): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (isset($filters['student_id'])) {
            $query->where('student_id', $filters['student_id']);
        }

        if (isset($filters['name'])) {
            $query->where('first_name', 'like', '%' . $filters['name'] . '%')
                ->orWhere('last_name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['email'])) {
            $query->where('email', $filters['email']);
        }

        if (isset($filters['phone'])) {
            $query->where('phone', $filters['phone']);
        }

        if (isset($filters['nrc'])) {
            $query->where('nrc', $filters['nrc']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (isset($filters['date_of_birth'])) {
            $query->whereBetween('date_of_birth', [$filters['date_of_birth']['start'], $filters['date_of_birth']['end']]);
        }

        if (isset($filters['enrollment_date'])) {
            $query->whereBetween('enrollment_date', [$filters['enrollment_date']['start'], $filters['enrollment_date']['end']]);
        }

        if (isset($filters['guardian_name'])) {
            $query->where('guardian_name', 'like', '%' . $filters['guardian_name'] . '%');
        }

        if (isset($filters['guardian_phone'])) {
            $query->where('guardian_phone', 'like', '%' . $filters['guardian_phone'] . '%');
        }

        if (isset($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction'] ?? 'asc');
        }

        return $query->paginate($filters['per_page'] ?? 10);
    }

    /**
     * Create a new student
     *
     * @param array $data
     * @return Student
     */
    public function create(array $data): Student
    {
        // Hash password
        $data['password'] = Hash::make($data['password']);

        // Set default status as pending
        $data['status'] = 'pending';

        // Generate student ID
        $data['student_id'] = $this->generateStudentId();

        return $this->model->create($data);
    }

    /**
     * Find student by ID
     *
     * @param int $id
     * @return Student|null
     */
    public function findById(int $id): ?Student
    {
        return $this->model->find($id);
    }

    // /**
    //  * Find student by student ID
    //  *
    //  * @param string $studentId
    //  * @return Student|null
    //  */
    // public function findByStudentId(string $studentId): ?Student
    // {
    //     return $this->model->where('student_id', $studentId)->first();
    // }

    /**
     * Find student by email
     *
     * @param string $email
     * @return Student|null
     */
    public function findByEmail(string $email): ?Student
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Update student data
     *
     * @param int $id
     * @param array $data
     * @return Student
     */
    public function update(int $id, array $data): Student
    {
        $student = $this->findById($id);
        if (!$student) {
            throw new ModelNotFoundException('Student not found');
        }

        $student->update($data);
        return $student->fresh();
    }

    /**
     * Generate unique student ID
     *
     * @return string
     */
    protected function generateStudentId(): string
    {
        $prefix = 'STU';
        $year = date('Y');
        $count = $this->model->count() + 1;
        return $prefix . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
