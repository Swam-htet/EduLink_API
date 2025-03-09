<?php

namespace App\Repositories;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements StudentRepositoryInterface
{
    public function findById(string $id): ?Student
    {
        return Student::find($id);
    }

    public function findByEmail(string $email): ?Student
    {
        return Student::where('email', $email)->first();
    }

    public function findByStudentId(string $studentId): ?Student
    {
        return Student::where('student_id', $studentId)->first();
    }

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(Student $student, array $data): Student
    {
        $student->update($data);
        return $student->fresh();
    }

    public function delete(Student $student): bool
    {
        return $student->delete();
    }

    public function getAll(): Collection
    {
        return Student::all();
    }

    public function getNextStudentId(): string
    {
        return 'STU' . str_pad(Student::count() + 1, 4, '0', STR_PAD_LEFT);
    }
}
