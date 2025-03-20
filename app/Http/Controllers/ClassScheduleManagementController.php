<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassSchedule\CreateClassScheduleRequest;
use App\Http\Requests\ClassSchedule\FindClassScheduleByIdRequest;
use App\Contracts\Services\ClassScheduleManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Resources\Management\ManagementClassScheduleResource;

class ClassScheduleManagementController extends Controller
{
    protected $scheduleService;

    public function __construct(ClassScheduleManagementServiceInterface $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index(): JsonResponse
    {
        $schedules = $this->scheduleService->getAllSchedules();

        return response()->json([
            'data' => ManagementClassScheduleResource::collection($schedules)
        ]);
    }

    private function show(FindClassScheduleByIdRequest $request): JsonResponse
    {
        $schedule = $this->scheduleService->getScheduleById($request->id);

        return response()->json([
            'data' => new ManagementClassScheduleResource($schedule)
        ]);
    }

    public function store(CreateClassScheduleRequest $request): JsonResponse
    {
        $schedules = $this->scheduleService->createMultipleSchedules($request->validated('schedules'));

        return response()->json([
            'message' => 'Class schedule created successfully.',
            'data' => ManagementClassScheduleResource::collection($schedules)
        ], Response::HTTP_CREATED);
    }
}
