<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CourseServiceInterface;
use App\Http\Requests\Course\FindCourseByIdRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $courses = $this->courseService->getAllActiveCourses();

        return response()->json([
            'data' => $courses
        ]);
    }

    /**
     * Get active course by ID
     *
     * @param FindCourseByIdRequest $request
     * @return JsonResponse
     */
    public function show(FindCourseByIdRequest $request): JsonResponse
    {
        $course = $this->courseService->getActiveCourseById($request->id);

        return response()->json([
            'data' => $course
        ]);
    }
}
