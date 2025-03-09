<?php

namespace App\Services;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Services\StudentManagementServiceInterface;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentManagementService implements StudentManagementServiceInterface
{
    /**
     * @var StudentRepositoryInterface
     */
    protected $studentRepository;

    /**
     * StudentManagementService constructor.
     *
     * @param StudentRepositoryInterface $studentRepository
     */
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Get all students
     *
     * @return Collection
     */
    public function getAllStudents(): Collection
    {
        return $this->studentRepository->getAll();
    }

    /**
     * Get a student by ID
     *
     * @param string $id
     * @return Student|null
     */
    public function getStudentById(string $id): ?Student
    {
        $student = $this->studentRepository->findById($id);

        if (!$student) {
            throw new ModelNotFoundException("Student with ID {$id} not found");
        }

        return $student;
    }

    /**
     * Update a student
     *
     * @param string $id
     * @param array $data
     * @return Student
     */
    public function updateStudent(string $id, array $data): Student
    {
        $student = $this->getStudentById($id);

        return $this->studentRepository->update($student, $data);
    }

    /**
     * Delete a student
     *
     * @param string $id
     * @return bool
     */
    public function deleteStudent(string $id): bool
    {
        $student = $this->getStudentById($id);

        return $this->studentRepository->delete($student);
    }
}
