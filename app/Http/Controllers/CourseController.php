<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CourseServiceInterface;
use App\Http\Requests\Course\ListCourseRequest;
use App\Http\Resources\CourseResource;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Get all active courses
     *
     * @param ListCourseRequest $request
     * @return JsonResponse
     */
    public function index(ListCourseRequest $request): JsonResponse
    {
        dd($request->validated());
        $courses = $this->courseService->getAllActiveCourses($request->filters());

        return response()->json([
            'data' => CourseResource::collection($courses)
        ]);
    }

    /**
     * Get active course by id
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $course = $this->courseService->getActiveCourseById($id);

        return response()->json([
            'data' => new CourseResource($course)
        ]);
    }
}
