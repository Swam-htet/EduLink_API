<?php

namespace App\Http\Controllers;

use App\Contracts\Services\StaffManagementServiceInterface;
use App\Http\Requests\Staff\StaffAccCreateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Staff\ListStaffRequest;
use App\Http\Resources\Management\ManagementStaffResource;
use Carbon\Carbon;
class StaffManagementController extends Controller
{
    protected $staffManagementService;

    public function __construct(StaffManagementServiceInterface $staffManagementService)
    {
        $this->staffManagementService = $staffManagementService;
    }

    /**
     * Get all staff members
     * @return JsonResponse
     */
    public function index(ListStaffRequest $request): JsonResponse
    {
        $value = $this->staffManagementService->getAllStaffs($request->filters());

        return response()->json([
            'data' => ManagementStaffResource::collection($value->items()),
            'meta' => [
                'total' => $value->total(),
                'per_page' => $value->perPage(),
                'current_page' => $value->currentPage(),
                'last_page' => $value->lastPage(),
            ],
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get staff member by id
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $staff = $this->staffManagementService->getStaffById($id);
        return response()->json([
            'data' => new ManagementStaffResource($staff),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
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
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_CREATED);
    }
}
