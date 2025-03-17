<?php

namespace App\Services\Student;

use App\Contracts\Services\StudentAuthServiceInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Models\Tenants\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class StudentAuthService implements StudentAuthServiceInterface
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Login student and generate token
     *
     * @param array $credentials
     * @return array
     * @throws ValidationException
     */
    public function login(array $credentials): array
    {
        $student = $this->studentRepository->findByEmail($credentials['email']);

        if (!$student || !Hash::check($credentials['password'], $student->password)) {
            throw new UnauthorizedHttpException('', 'Invalid credentials');
        }

        // status check - pending, active, inactive, graduated, suspended, rejected
        $unapprovedStatuses = ['pending', 'inactive', 'suspended', 'rejected'];

        if (in_array($student->status, $unapprovedStatuses)) {
            throw ValidationException::withMessages([
                'email' => ['Your account is not approved yet or currently suspended. Please contact the administrator.'],
            ]);
        }

        // Create new token
        $tokenResult = $student->createToken('student-token', ['student']);

        return [
            'student' => $student,
            'token' => $tokenResult->accessToken,
            'expires_at' => $tokenResult->token->expires_at,
            'token_type' => 'Bearer'
        ];
    }

    /**
     * Logout student and revoke tokens
     *
     * @param Student $student
     * @return bool
     */
    public function logout(Student $student): bool
    {
        return (bool) $student->token()->revoke();
    }

}
