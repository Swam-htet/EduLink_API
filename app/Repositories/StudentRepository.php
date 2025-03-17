<?php

namespace App\Repositories;

use App\Models\Tenants\Student;
use App\Contracts\Repositories\StudentRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
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

    /**
     * Find student by student ID
     *
     * @param string $studentId
     * @return Student|null
     */
    public function findByStudentId(string $studentId): ?Student
    {
        return $this->model->where('student_id', $studentId)->first();
    }

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
