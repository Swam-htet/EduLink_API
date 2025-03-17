<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Student;

interface StudentRepositoryInterface
{
    /**
     * Create a new student
     *
     * @param array $data
     * @return Student
     */
    public function create(array $data): Student;

    /**
     * Find student by ID
     *
     * @param int $id
     * @return Student|null
     */
    public function findById(int $id): ?Student;

    /**
     * Find student by student ID
     *
     * @param string $studentId
     * @return Student|null
     */
    public function findByStudentId(string $studentId): ?Student;

    /**
     * Find student by email
     *
     * @param string $email
     * @return Student|null
     */
    public function findByEmail(string $email): ?Student;


    /**
     * Update student data
     *
     * @param int $id
     * @param array $data
     * @return Student
     */
    public function update(int $id, array $data): Student;
}
