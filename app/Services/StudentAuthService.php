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
    /**
     * @var StudentRepositoryInterface
     */
    protected $studentRepository;

    /**
     * StudentAuthService constructor.
     *
     * @param StudentRepositoryInterface $studentRepository
     */
    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Login a student
     *
     * @param LoginRequest $request
     * @return array
     */
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

    /**
     * Logout a student
     *
     * @param Request $request
     * @return bool
     */
    public function logout(Request $request): bool
    {
        return $request->user()->token()->revoke();
    }

    /**
     * Get student profile
     *
     * @param Request $request
     * @return Student
     */
    public function getProfile(Request $request): Student
    {
        return $request->user();
    }
}
