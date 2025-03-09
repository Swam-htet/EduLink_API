<?php

namespace App\Contracts\Services;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface StudentManagementServiceInterface
{
    /**
     * Get all students
     *
     * @return Collection
     */
    public function getAllStudents(): Collection;

    /**
     * Get a student by ID
     *
     * @param string $id
     * @return Student|null
     */
    public function getStudentById(string $id): ?Student;

    /**
     * Update a student
     *
     * @param string $id
     * @param array $data
     * @return Student
     */
    public function updateStudent(string $id, array $data): Student;

    /**
     * Delete a student
     *
     * @param string $id
     * @return bool
     */
    public function deleteStudent(string $id): bool;
}
