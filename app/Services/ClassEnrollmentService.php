<?php

namespace App\Services;

use App\Contracts\Services\ClassEnrollmentServiceInterface;
use App\Helpers\TokenHelper;
use App\Contracts\Repositories\StudentClassEnrollmentRepositoryInterface;
use Illuminate\Validation\ValidationException;
use App\Models\Tenants\StudentClassEnrollment;
use Illuminate\Pagination\LengthAwarePaginator;

class ClassEnrollmentService implements ClassEnrollmentServiceInterface
{
    protected $enrollmentRepository;

    public function __construct(StudentClassEnrollmentRepositoryInterface $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    /**
     * Get enrollments by student ID with filters
     *
     * @param int $studentId
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getEnrollmentsByStudentId(int $studentId, array $filters): LengthAwarePaginator
    {
        return $this->enrollmentRepository->getPaginatedEnrollmentsByStudentId($studentId, $filters);
    }

    /**
     * Confirm enrollment using token
     *
     * @param string $token
     * @return StudentClassEnrollment
     * @throws ValidationException
     */
    public function confirmEnrollment(string $token): StudentClassEnrollment
    {
        // Validate token
        $tokenRecord = TokenHelper::validateToken($token, 'enrollment');

        if (!$tokenRecord) {
            throw ValidationException::withMessages([
                'token' => 'Invalid token'
            ]);
        }

        // Get enrollment
        $enrollment = $this->enrollmentRepository->findById($tokenRecord->tokenable_id);

        if (!$enrollment) {
            throw ValidationException::withMessages([
                'token' => 'Enrollment not found'
            ]);
        }

        $isFull = $this->enrollmentRepository->getCompletedEnrollmentsByClassId($enrollment->class_id)->count() >= $enrollment->class->capacity;

        if ($enrollment->status !== 'enrolled' || $enrollment->class->start_date->isPast() || $isFull) {
            throw ValidationException::withMessages([
                'token' => 'Can\'t confirm enrollment because of invalid status or class has already started or full.'
            ]);
        }

        // Update enrollment status
        $enrollment = $this->enrollmentRepository->updateStatus($enrollment, 'completed');

        // Mark token as used
        TokenHelper::markTokenAsUsed($token, 'enrollment');

        return $enrollment;
    }
}
