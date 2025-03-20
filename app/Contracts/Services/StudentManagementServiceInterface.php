<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Student;
use Illuminate\Pagination\LengthAwarePaginator;
interface StudentManagementServiceInterface
{
    /**
     * Approve student registration
     *
     * @param array $data
     * @return Student
     */
    public function approveRegistration(array $data): Student;

    /**
     * Reject student registration
     *
     * @param array $data
     * @return Student
     */
    public function rejectRegistration(array $data): Student;

    /**
     * Get all students with filters
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllStudents(array $filters): LengthAwarePaginator;
}
