<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AttendanceServiceInterface;
use App\Http\Requests\Attendance\MakeAttendanceRequest;
use App\Http\Requests\Attendance\ListAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceServiceInterface $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Make attendance for student
     */
    public function makeAttendance(MakeAttendanceRequest $request, string $studentId): JsonResponse
    {
        $attendance = $this->attendanceService->makeAttendance(
            (int) $studentId,
            $request->validated()
        );

        return response()->json([
            'message' => 'Attendance recorded successfully',
            'data' => new AttendanceResource($attendance)
        ], Response::HTTP_CREATED);
    }

    /**
     * Get attendances by student ID
     */
    public function getAttendancesByStudentId(ListAttendanceRequest $request, string $studentId): JsonResponse
    {
        $attendances = $this->attendanceService->getAttendancesByStudentId(
            (int) $studentId,
            $request->filters()
        );

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
