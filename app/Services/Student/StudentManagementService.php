<?php

namespace App\Services\Student;

use App\Contracts\Services\StudentManagementServiceInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Models\Tenants\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use App\Mail\Student\RegistrationApprovedMail;
use App\Mail\Student\RegistrationRejectedMail;
class StudentManagementService implements StudentManagementServiceInterface
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Approve student registration
     *
     * @param array $data
     * @return Student
     */
    public function approveRegistration(array $data): Student
    {
        DB::beginTransaction();
        try {
            $student = $this->studentRepository->findById($data['id']);

            if (!$student) {
                throw ValidationException::withMessages([
                    'id' => ['Student not found.']
                ]);
            }

            if ($student->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => ['Student registration is not in pending status.']
                ]);
            }

            // Update student status to active
            $student = $this->studentRepository->update($student->id, [
                'status' => 'active',
            ]);

            Mail::to($student->email)->send(new RegistrationApprovedMail([
                'name' => $student->name,
                'email' => $student->email,
                'student_id' => $student->student_id,
                // todo : need to fix later with dynamic student portal login url
                'login_url' =>  '/login',
            ]));

            DB::commit();
            return $student;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reject student registration
     *
     * @param array $data
     * @return Student
     */
    public function rejectRegistration(array $data): Student
    {
        DB::beginTransaction();
        try {
            $student = $this->studentRepository->findById($data['id']);

            if (!$student) {
                throw ValidationException::withMessages([
                    'id' => ['Student not found.']
                ]);
            }

            if ($student->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => ['Student registration is not in pending status.']
                ]);
            }

            // Update student status to rejected
            $student = $this->studentRepository->update($student->id, [
                'status' => 'rejected',
            ]);

            Mail::to($student->email)->send(new RegistrationRejectedMail([
                'name' => $student->name,
                'email' => $student->email,
                'student_id' => $student->student_id,
                'reason' => $data['reason'] ?? "Student registration rejected by admin",
            ]));

            DB::commit();
            return $student;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getAllStudents(array $filters): LengthAwarePaginator
    {
        return $this->studentRepository->getPaginatedStudents($filters);
    }

    public function getStudentById(int $id): Student
    {
        return $this->studentRepository->findById($id);
    }
}
