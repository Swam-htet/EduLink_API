<?php

namespace App\Contracts\Repositories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

interface StudentRepositoryInterface
{
    /**
     * Find a student by ID
     *
     * @param string $id
     * @return Student|null
     */
    public function findById(string $id): ?Student;

    /**
     * Find a student by email
     *
     * @param string $email
     * @return Student|null
     */
    public function findByEmail(string $email): ?Student;

    /**
     * Find a student by student ID
     *
     * @param string $studentId
     * @return Student|null
     */
    public function findByStudentId(string $studentId): ?Student;

    /**
     * Create a new student
     *
     * @param array $data
     * @return Student
     */
    public function create(array $data): Student;

    /**
     * Update a student
     *
     * @param Student $student
     * @param array $data
     * @return Student
     */
    public function update(Student $student, array $data): Student;

    /**
     * Delete a student
     *
     * @param Student $student
     * @return bool
     */
    public function delete(Student $student): bool;

    /**
     * Get all students
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get the next student ID
     *
     * @return string
     */
    public function getNextStudentId(): string;
}
