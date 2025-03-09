<?php

namespace App\Services;

use App\Contracts\Services\TokenServiceInterface;
use App\Models\Staff;
use App\Models\Student;

class TokenService implements TokenServiceInterface
{
    public function createStudentToken(Student $student): string
    {
        $tokenResult = $student->createToken('Student Access Token', ['student']);
        return $tokenResult->accessToken;
    }

    public function createStaffToken(Staff $staff): string
    {
        $tokenResult = $staff->createToken('Staff Access Token', ['staff', 'admin']);
        return $tokenResult->accessToken;
    }
}
