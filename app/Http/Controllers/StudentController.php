<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentRegistrationRequest;
use App\Contracts\Services\StudentRegistrationServiceInterface;
use Illuminate\Http\Response;
use App\Http\Resources\StudentResource;
class StudentController extends Controller
{
    protected $registrationService;

    public function __construct(StudentRegistrationServiceInterface $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function register(StudentRegistrationRequest $request)
    {
        $student = $this->registrationService->register($request->validated());

        return response()->json([
            'message' => 'Registration successful. Please wait for admin approval.',
            'data' => new StudentResource($student)
        ], Response::HTTP_CREATED);
    }
}
