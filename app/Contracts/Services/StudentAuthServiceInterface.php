<?php

namespace App\Contracts\Services;

use App\Http\Requests\Student\LoginRequest;
use App\Models\Student;
use Illuminate\Http\Request;

interface StudentAuthServiceInterface
{
    /**
     * Login a student
     *
     * @param LoginRequest $request
     * @return array
     */
    public function login(LoginRequest $request): array;

    /**
     * Logout a student
     *
     * @param Request $request
     * @return bool
     */
    public function logout(Request $request): bool;

    /**
     * Get student profile
     *
     * @param Request $request
     * @return Student
     */
    public function getProfile(Request $request): Student;
}
