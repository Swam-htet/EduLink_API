<?php

namespace App\Http\Controllers;

use App\Http\Requests\Class\CreateClassScheduleRequest;
use App\Http\Requests\Class\FindClassScheduleByIdRequest;
use App\Contracts\Services\ClassScheduleManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
            'data' => $schedules
        ]);
    }

    public function show(FindClassScheduleByIdRequest $request): JsonResponse
    {
        $schedule = $this->scheduleService->getScheduleById($request->id);

        return response()->json([
            'data' => $schedule
        ]);
    }

    public function store(CreateClassScheduleRequest $request): JsonResponse
    {
        $schedule = $this->scheduleService->createSchedule($request->validated());

        return response()->json([
            'message' => 'Class schedule created successfully.',
            'data' => $schedule
        ], Response::HTTP_CREATED);
    }
}