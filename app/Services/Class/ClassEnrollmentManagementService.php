<?php

namespace App\Services\Class;

use App\Contracts\Services\ClassEnrollmentManagementServiceInterface;
use App\Contracts\Repositories\StudentClassEnrollmentRepositoryInterface;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\TokenHelper;
use Illuminate\Support\Collection;


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

    /**
     * Get paginated enrollments
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedEnrollments(array $filters): LengthAwarePaginator
    {
        return $this->enrollmentRepository->getPaginatedEnrollments($filters);
    }

    /**
     * Enroll student to class
     *
     * @param array $data
     * @return StudentClassEnrollment
     */
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
            $numberOfCompletedEnrollments = $this->enrollmentRepository->getCompletedEnrollmentsByStudentId($data['student_id'])->count();
            if ($numberOfCompletedEnrollments >= $class->capacity) {
                throw ValidationException::withMessages([
                    'class_id' => ['Class has reached its maximum capacity.']
                ]);
            }

            // Create enrollment
            $enrollment = $this->enrollmentRepository->create($data);

            $this->sendEnrollmentEmail($enrollment, $student);

            DB::commit();
            return $enrollment;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Enroll students to class
     *
     * @param array $data
     * @return Collection
     */
    public function enrollStudents(array $data): Collection
    {
        DB::beginTransaction();
        try {
            $enrollments = [];

        foreach ($data['student_ids'] as $studentId) {
            $enrollments[] = $this->enrollStudent([
                'student_id' => $studentId,
                'class_id' => $data['class_id']
            ]);
        }

            DB::commit();
            return collect($enrollments);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update enrollment
     *
     * @param array $data
     * @return StudentClassEnrollment
     */
    public function update(array $data): StudentClassEnrollment
    {
        return $this->enrollmentRepository->update($data['id'], $data);
    }

    /**
     * Send enrollment email
     *
     * @param array $data
     * @return void
     */
    public function sendEnrollmentEmail($enrollment, $student): void
    {
        //    create token for student
        $generatedToken = TokenHelper::generateToken($enrollment, 'enrollment');

        $url = config('app.url') . '?token=' . $generatedToken->token;

        //    todo : need to add email template
        // Mail::to($student->email)->send(new ClassInvitationEmail($enrollment, $customMessage, $url));
    }

    public function sendManualEnrollmentEmail(array $data): void
    {
        $enrollmentIds = $data['enrollment_ids'];

        $enrollments = [];

        foreach ($enrollmentIds as $enrollmentId) {
            $enrollments[] = $this->enrollmentRepository->findById($enrollmentId);
        }

        foreach ($enrollments as $enrollment) {
            $this->sendEnrollmentEmail($enrollment, $enrollment->student);
        }
    }



    /**
     * Get completely enrolled students by class ID
     *
     * @param int $classId
     * @return Collection
     */
    public function getCompletelyEnrolledStudentsByClassId(int $classId): Collection
    {
        $enrollments = $this->enrollmentRepository->getCompletedEnrollmentsByClassId($classId);

        $students = collect([]);

        foreach ($enrollments as $enrollment) {
            $students->push($enrollment->student);
        }

        return $students;
    }
}
