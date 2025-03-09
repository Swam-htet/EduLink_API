<?php

namespace App\Contracts\Services;

use App\Http\Requests\Student\RegisterRequest;
use App\Models\Student;

interface StudentRegistrationServiceInterface
{
    /**
     * Register a new student with transaction and email notification
     *
     * @param RegisterRequest $request
     * @return Student
     */
    public function registerStudent(RegisterRequest $request): Student;
}
