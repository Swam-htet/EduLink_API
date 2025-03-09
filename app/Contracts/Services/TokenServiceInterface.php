<?php

namespace App\Contracts\Services;

use App\Models\Staff;
use App\Models\Student;

interface TokenServiceInterface
{
    public function createStudentToken(Student $student): string;

    public function createStaffToken(Staff $staff): string;
}
