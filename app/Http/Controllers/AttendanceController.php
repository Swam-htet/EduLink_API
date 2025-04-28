<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AttendanceServiceInterface;
use App\Http\Requests\Attendance\MakeAttendanceRequest;
use App\Http\Requests\Attendance\ListAttendanceRequest;
use App\Http\Resources\AttendanceResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
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
    public function makeAttendance(MakeAttendanceRequest $request) : JsonResponse
    {
        $studentId = $request->user()->id;

        $this->attendanceService->makeAttendance($studentId, $request->validated());

        return response()->json([
            'message' => 'Attendance recorded successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_CREATED);
    }
}
