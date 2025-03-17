<?php

namespace App\Services\Student;

use App\Contracts\Services\StudentRegistrationServiceInterface;
use App\Contracts\Repositories\StudentRepositoryInterface;
use App\Mail\Student\RegistrationPendingMail;
use App\Models\Tenants\Student;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class StudentRegistrationService implements StudentRegistrationServiceInterface
{
    protected $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * Register a new student
     *
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function register(array $data) : Student
    {
        DB::beginTransaction();
        try {
            // Create the student
            $student = $this->studentRepository->create($data);

            // Send registration pending email
            Mail::to($student->email)->queue(new RegistrationPendingMail([
                'name' => $student->name,
                'email' => $student->email,
                'student_id' => $student->student_id
            ]));

            DB::commit();
            return $student;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
