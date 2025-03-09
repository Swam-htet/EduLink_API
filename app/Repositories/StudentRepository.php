<?php

namespace App\Repositories;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements StudentRepositoryInterface
{
    /**
     * Find a student by ID
     *
     * @param string $id
     * @return Student|null
     */
    public function findById(string $id): ?Student
    {
        return Student::find($id);
    }

    /**
     * Find a student by email
     *
     * @param string $email
     * @return Student|null
     */
    public function findByEmail(string $email): ?Student
    {
        return Student::where('email', $email)->first();
    }

    /**
     * Find a student by student ID
     *
     * @param string $studentId
     * @return Student|null
     */
    public function findByStudentId(string $studentId): ?Student
    {
        return Student::where('student_id', $studentId)->first();
    }

    /**
     * Create a new student
     *
     * @param array $data
     * @return Student
     */
    public function create(array $data): Student
    {
        return Student::create($data);
    }

    /**
     * Update a student
     *
     * @param Student $student
     * @param array $data
     * @return Student
     */
    public function update(Student $student, array $data): Student
    {
        $student->update($data);
        return $student->fresh();
    }

    /**
     * Delete a student
     *
     * @param Student $student
     * @return bool
     */
    public function delete(Student $student): bool
    {
        return $student->delete();
    }

    /**
     * Get all students
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Student::all();
    }

    /**
     * Get the next student ID
     *
     * @return string
     */
    public function getNextStudentId(): string
    {
        return 'STU' . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);
    }
}
