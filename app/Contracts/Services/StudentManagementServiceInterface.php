<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Student;

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
}