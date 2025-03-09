<?php

namespace App\Services;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Services\StudentManagementServiceInterface;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentManagementService implements StudentManagementServiceInterface
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function getAllStudents(): Collection
    {
        return $this->studentRepository->getAll();
    }

    public function getStudentById(string $id): ?Student
    {
        $student = $this->studentRepository->findById($id);

        if (!$student) {
            throw new ModelNotFoundException("Student with ID {$id} not found");
        }

        return $student;
    }

    public function updateStudent(string $id, array $data): Student
    {
        $student = $this->getStudentById($id);

        return $this->studentRepository->update($student, $data);
    }

    public function deleteStudent(string $id): bool
    {
        $student = $this->getStudentById($id);

        return $this->studentRepository->delete($student);
    }
}
