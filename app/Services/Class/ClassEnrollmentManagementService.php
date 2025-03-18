<?php

namespace App\Services\Class;

use App\Contracts\Services\ClassEnrollmentManagementServiceInterface;
use App\Contracts\Repositories\StudentClassEnrollmentRepositoryInterface;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClassEnrollmentManagementService implements ClassEnrollmentManagementServiceInterface
{
    protected $enrollmentRepository;
    protected $classRepository;
    protected $studentRepository;

    public function __construct(
        StudentClassEnrollmentRepositoryInterface $enrollmentRepository,
        ClassRepositoryInterface $classRepository,
        StudentRepositoryInterface $studentRepository
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->classRepository = $classRepository;
        $this->studentRepository = $studentRepository;
    }

    public function enrollStudent(array $data): StudentClassEnrollment
    {
        DB::beginTransaction();
        try {
            // Check if class exists and is active
            $class = $this->classRepository->findById($data['class_id']);
            if (!$class || $class->status !== 'ongoing') {
                throw ValidationException::withMessages([
                    'class_id' => ['Class not found or not ongoing.']
                ]);
            }

            // Check if student exists and is active
            $student = $this->studentRepository->findById($data['student_id']);
            if (!$student || $student->status !== 'active') {
                throw ValidationException::withMessages([
                    'student_id' => ['Student not found or not active.']
                ]);
            }

            // Check if student is already enrolled
            if ($this->enrollmentRepository->isStudentEnrolled($data['student_id'], $data['class_id'])) {
                throw ValidationException::withMessages([
                    'student_id' => ['Student is already enrolled in this class.']
                ]);
            }

            // Check class capacity
            $currentEnrollments = $this->enrollmentRepository->getEnrollmentsByClassId($data['class_id'])->count();
            if ($currentEnrollments >= $class->capacity) {
                throw ValidationException::withMessages([
                    'class_id' => ['Class has reached its maximum capacity.']
                ]);
            }

            // Create enrollment
            $enrollment = $this->enrollmentRepository->create($data);

            DB::commit();
            return $enrollment;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
