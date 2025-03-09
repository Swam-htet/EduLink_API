<?php

namespace App\Services;

use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Contracts\Services\MailServiceInterface;
use App\Contracts\Services\StudentRegistrationServiceInterface;
use App\Http\Requests\Student\RegisterRequest;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class StudentRegistrationService implements StudentRegistrationServiceInterface
{
    protected $mailService;

    protected $studentRepository;

    public function __construct(
        MailServiceInterface $mailService,
        StudentRepositoryInterface $studentRepository
    ) {
        $this->mailService = $mailService;
        $this->studentRepository = $studentRepository;
    }

    public function registerStudent(RegisterRequest $request): Student
    {
        try {
            // Start database transaction
            return DB::transaction(function () use ($request) {
                $validatedData = $request->validated();

                // Hash the password
                $validatedData['password'] = Hash::make($validatedData['password']);

                // Generate a unique student ID
                $validatedData['student_id'] = $this->studentRepository->getNextStudentId();

                // Create the student
                $student = $this->studentRepository->create($validatedData);

                // Send registration success email
                $this->sendRegistrationEmail($student);

                return $student;
            });
        } catch (Exception $e) {
            Log::error('Student registration failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Send registration success email to the student
     *
     * @param Student $student
     * @return void
     */
    private function sendRegistrationEmail(Student $student): void
    {
        $subject = 'Welcome to EduLink - Registration Successful';
        $message = view('emails.student.registration', [
            'student' => $student,
            'loginUrl' => config('app.url') . '/student/login'
        ])->render();

        try {
            $this->mailService->sendNotificationEmail($student->email, $subject, $message);
        } catch (Exception $e) {
            // Log the error but don't fail the registration process
            Log::error('Failed to send registration email: ' . $e->getMessage());
        }
    }
}
