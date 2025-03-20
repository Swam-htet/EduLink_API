<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\ApproveRegistrationRequest;
use App\Http\Requests\Student\RejectRegistrationRequest;
use App\Contracts\Services\StudentManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Management\ManagementStudentResource;
use App\Http\Requests\Student\ListStudentRequest;
class StudentManagementController extends Controller
{
    protected $managementService;

    public function __construct(StudentManagementServiceInterface $managementService)
    {
        $this->managementService = $managementService;
    }

    /**
     * List students
     *
     * @param ListStudentRequest $request
     * @return JsonResponse
     */
    public function index(ListStudentRequest $request): JsonResponse
    {
        $value = $this->managementService->getAllStudents($request->filters());

        return response()->json([
            'data' => ManagementStudentResource::collection($value->items()),
            'meta' => [
                'total' => $value->total(),
                'per_page' => $value->perPage(),
                'current_page' => $value->currentPage(),
                'last_page' => $value->lastPage(),
            ]
        ]);
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
            'data' => new ManagementStudentResource($student)
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
            'data' => new ManagementStudentResource($student)
        ]);

    }
}