<?php

namespace App\Contracts\Repositories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

interface StudentRepositoryInterface
{
    public function findById(string $id): ?Student;

    public function findByEmail(string $email): ?Student;

    public function findByStudentId(string $studentId): ?Student;

    public function create(array $data): Student;

    public function update(Student $student, array $data): Student;

    public function delete(Student $student): bool;

    public function getAll(): Collection;

    public function getNextStudentId(): string;
}
