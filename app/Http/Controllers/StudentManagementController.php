<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\ApproveRegistrationRequest;
use App\Http\Requests\Student\RejectRegistrationRequest;
use App\Contracts\Services\StudentManagementServiceInterface;
use Illuminate\Http\JsonResponse;

class StudentManagementController extends Controller
{
    protected $managementService;

    public function __construct(StudentManagementServiceInterface $managementService)
    {
        $this->managementService = $managementService;
    }

    /**
     * Approve student registration
     *
     * @param ApproveRegistrationRequest $request
     * @return JsonResponse
     */
    public function approveRegistration(ApproveRegistrationRequest $request): JsonResponse
    {
        $student = $this->managementService->approveRegistration($request->validated());

        return response()->json([
            'message' => 'Student registration approved successfully.',
            'data' => $student
        ]);

    }

    /**
     * Reject student registration
     *
     * @param RejectRegistrationRequest $request
     * @return JsonResponse
     */
    public function rejectRegistration(RejectRegistrationRequest $request): JsonResponse
    {
        $student = $this->managementService->rejectRegistration($request->validated());

        return response()->json([
            'message' => 'Student registration rejected successfully.',
            'data' => $student
        ]);

    }
}