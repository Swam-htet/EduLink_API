<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClassScheduleServiceInterface;
use App\Http\Requests\ClassSchedule\ListClassScheduleRequest;
use App\Http\Resources\ClassScheduleResource;
use App\Http\Resources\ClassScheduleDetailResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Class\FindClassByIdRequest;
class ClassScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ClassScheduleServiceInterface $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display a listing of the class schedules.
     */
    public function index(ListClassScheduleRequest $request): JsonResponse
    {
        $schedules = $this->scheduleService->getSchedules($request->filters());

        return response()->json([
            'data' => ClassScheduleResource::collection($schedules),
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified class schedule.
     */
    public function show(FindClassByIdRequest $request, string $id): JsonResponse
    {
        $schedule = $this->scheduleService->getScheduleById(
            (int) $id,
            $request->student_id
        );

        return response()->json([
            'data' => new ClassScheduleDetailResource($schedule)
        ], Response::HTTP_OK);
    }
}
