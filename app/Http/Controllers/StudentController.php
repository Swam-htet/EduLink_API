<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StudentRegistrationRequest;
use App\Contracts\Services\StudentRegistrationServiceInterface;
use Illuminate\Http\Response;
use App\Http\Resources\StudentResource;
use Carbon\Carbon;

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
            'data' => new StudentResource($student),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_CREATED);
    }
}
