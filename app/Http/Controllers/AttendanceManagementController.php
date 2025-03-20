<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AttendanceManagementServiceInterface;
use App\Http\Requests\Attendance\ManualAttendanceRequest;
use App\Http\Requests\Attendance\ListManagementAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AttendanceManagementController extends Controller
{
    protected $attendanceManagementService;

    public function __construct(AttendanceManagementServiceInterface $attendanceManagementService)
    {
        $this->attendanceManagementService = $attendanceManagementService;
    }

    public function makeManualAttendance(ManualAttendanceRequest $request): JsonResponse
    {
        $attendance = $this->attendanceManagementService->makeManualAttendance($request->validated());

        return response()->json([
            'message' => 'Attendance recorded successfully',
            'data' => new AttendanceResource($attendance->load(['student', 'classSchedule.class']))
        ], Response::HTTP_CREATED);
    }

    public function getAttendances(ListManagementAttendanceRequest $request): JsonResponse
    {
        $attendances = $this->attendanceManagementService->getFilteredAttendances($request->filters());

        return response()->json([
            'data' => AttendanceResource::collection($attendances),
            'meta' => [
                'total' => $attendances->total(),
                'per_page' => $attendances->perPage(),
                'current_page' => $attendances->currentPage(),
                'last_page' => $attendances->lastPage(),
            ]
        ], Response::HTTP_OK);
    }
}
