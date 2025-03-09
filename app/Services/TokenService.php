<?php

namespace App\Services;

use App\Models\Staff;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class TokenService
{
    /**
     * Create a token for a student
     *
     * @param Student $student
     * @return string
     */
    public function createStudentToken(Student $student): string
    {
        $tokenResult = $student->createToken('Student Access Token', ['student']);
        return $tokenResult->accessToken;
    }

    /**
     * Create a token for a staff member
     *
     * @param Staff $staff
     * @return string
     */
    public function createStaffToken(Staff $staff): string
    {
        $tokenResult = $staff->createToken('Staff Access Token', ['staff', 'admin']);
        return $tokenResult->accessToken;
    }
}
