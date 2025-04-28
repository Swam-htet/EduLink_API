<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassSchedule\CreateClassScheduleRequest;
use App\Contracts\Services\ClassScheduleManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Resources\Management\ManagementClassScheduleResource;
use App\Http\Requests\ClassSchedule\ListClassScheduleRequest;
use Carbon\Carbon;

class ClassScheduleManagementController extends Controller
{
    protected $scheduleService;

    public function __construct(ClassScheduleManagementServiceInterface $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index(ListClassScheduleRequest $request): JsonResponse
    {
        $schedules = $this->scheduleService->getAllSchedules($request->validated());

        return response()->json([
            'data' => ManagementClassScheduleResource::collection($schedules),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    public function store(CreateClassScheduleRequest $request): JsonResponse
    {
        $schedules = $this->scheduleService->createMultipleSchedules($request->validated('schedules'));

        return response()->json([
            'message' => 'Class schedule created successfully.',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_CREATED);
    }
}
