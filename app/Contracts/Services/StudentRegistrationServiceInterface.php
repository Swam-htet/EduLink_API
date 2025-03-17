<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Student;

interface StudentRegistrationServiceInterface
{
    /**
     * Register a new student
     *
     * @param array $data
     * @return mixed
     */
    public function register(array $data) : Student;
}
