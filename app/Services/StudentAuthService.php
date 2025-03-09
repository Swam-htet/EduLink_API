<?php

namespace App\Services;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Services\StudentAuthServiceInterface;
use App\Http\Requests\Student\LoginRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StudentAuthService implements StudentAuthServiceInterface
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function login(LoginRequest $request): array
    {
        $student = $this->studentRepository->findByEmail($request->email);

        if (!$student || !Hash::check($request->password, $student->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $student->createToken('Student Access Token', ['student'])->accessToken;

        return [
            'token' => $token,
            'student' => $student
        ];
    }


    public function logout(Request $request): bool
    {
        return $request->user()->token()->revoke();
    }

    public function getProfile(Request $request): Student
    {
        return $request->user();
    }
}
