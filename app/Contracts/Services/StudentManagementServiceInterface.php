<?php

namespace App\Contracts\Services;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface StudentManagementServiceInterface
{

    public function getAllStudents(): Collection;

    public function getStudentById(string $id): ?Student;

    public function updateStudent(string $id, array $data): Student;

    public function deleteStudent(string $id): bool;
}
