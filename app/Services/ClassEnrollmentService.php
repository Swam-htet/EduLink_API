<?php

namespace App\Services;

use App\Contracts\Services\ClassEnrollmentServiceInterface;
use App\Helpers\TokenHelper;
use App\Contracts\Repositories\StudentClassEnrollmentRepositoryInterface;
use Illuminate\Validation\ValidationException;
use App\Models\Tenants\StudentClassEnrollment;

class ClassEnrollmentService implements ClassEnrollmentServiceInterface
{
    protected $enrollmentRepository;

    public function __construct(StudentClassEnrollmentRepositoryInterface $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    /**
     * Confirm enrollment using token
     *
     * @param string $token
     * @return StudentClassEnrollment
     * @throws \Exception
     */
    public function confirmEnrollment(string $token): StudentClassEnrollment
    {
        // Validate token
        $tokenRecord = TokenHelper::validateToken($token, 'enrollment');

        if(!$tokenRecord) {
            throw ValidationException::withMessages([
                'token' => 'Invalid token'
            ]);
        }

        // student
        $enrollment = $this->enrollmentRepository->findById($tokenRecord->tokenable_id);

        if(!$enrollment) {
            throw ValidationException::withMessages([
                'token' => 'Enrollment not found'
            ]);
        }

        $isFull = StudentClassEnrollment::where('class_id', $enrollment->class_id)->where('status', 'completed')->count() >= $enrollment->class->capacity;

        $condition = $enrollment->status !== 'enrolled' || $enrollment->class->start_date->isPast() || $isFull;
        if($condition) {
            throw ValidationException::withMessages([
                'token' => 'Can\'t confirm enrollment because of invalid status or class has already started or full.'
            ]);
        }

        // update enrollment status to 'completed'
        $enrollment->status = 'completed';

        $enrollment->save();

        // make token as used
        TokenHelper::markTokenAsUsed($token, 'enrollment');

        return $enrollment;
    }
}