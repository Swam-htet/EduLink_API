<?php

namespace App\Contracts\Services;

use App\Http\Requests\Student\RegisterRequest;
use App\Models\Student;

interface StudentRegistrationServiceInterface
{
    public function registerStudent(RegisterRequest $request): Student;
}
