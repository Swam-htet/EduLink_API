<?php

namespace App\Http\Controllers;

use App\Contracts\Services\StaffManagementServiceInterface;
use App\Http\Requests\Staff\StaffAccCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StaffManagementController extends Controller
{
    protected $staffManagementService;

    public function __construct(StaffManagementServiceInterface $staffManagementService)
    {
        $this->staffManagementService = $staffManagementService;
    }

    public function index(): JsonResponse
    {
        $staffs = $this->staffManagementService->getAllStaffs();
        return response()->json($staffs);
    }

    public function show($id): JsonResponse
    {
        $staff = $this->staffManagementService->getStaffById($id);
        return response()->json($staff);
    }



    /**
     * Create a new staff member
     *
     * @param StaffAccCreateRequest $request
     * @return JsonResponse
     */
    public function create(StaffAccCreateRequest $request): JsonResponse
    {
        $staff = $this->staffManagementService->createStaff($request->validated());
        return response()->json([
            'message' => 'Staff created successfully',
            'data' => $staff
        ], Response::HTTP_CREATED);
    }
}
