<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentRegistrationRequest;
use App\Contracts\Services\StudentRegistrationServiceInterface;
use Illuminate\Http\Response;

class StudentController extends Controller
{
    protected $registrationService;

    public function __construct(StudentRegistrationServiceInterface $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function register(StudentRegistrationRequest $request)
    {
        try {
            $student = $this->registrationService->register($request->validated());

            return response()->json([
                'message' => 'Registration successful. Please wait for admin approval.',
                'data' => $student
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed.',
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
