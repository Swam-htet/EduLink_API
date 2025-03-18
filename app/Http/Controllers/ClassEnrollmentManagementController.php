<?php

namespace App\Http\Controllers;

use App\Http\Requests\Class\EnrollStudentRequest;
use App\Contracts\Services\ClassEnrollmentManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClassEnrollmentManagementController extends Controller
{
    protected $enrollmentService;

    public function __construct(ClassEnrollmentManagementServiceInterface $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * Enroll student to class
     *
     * @param EnrollStudentRequest $request
     * @return JsonResponse
     */
    public function enrollStudent(EnrollStudentRequest $request): JsonResponse
    {
        $enrollment = $this->enrollmentService->enrollStudent($request->validated());

        return response()->json([
            'message' => 'Student enrolled successfully.',
            'data' => $enrollment
        ], Response::HTTP_CREATED);
    }
}
