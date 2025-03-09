<?php

namespace App\Contracts\Services;

use App\Http\Requests\Student\LoginRequest;
use App\Models\Student;
use Illuminate\Http\Request;

interface StudentAuthServiceInterface
{

    public function login(LoginRequest $request): array;

    public function logout(Request $request): bool;

    public function getProfile(Request $request): Student;
}
