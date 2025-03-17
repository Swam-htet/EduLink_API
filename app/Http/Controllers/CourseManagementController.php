<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\Course\FindCourseByIdRequest;
use App\Http\Requests\Course\DeleteCourseRequest;
use App\Contracts\Services\CourseManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CourseManagementController extends Controller
{
    protected $courseService;

    public function __construct(CourseManagementServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(): JsonResponse
    {
        $courses = $this->courseService->getAllCourses();

        return response()->json([
            'data' => $courses
        ]);
    }

    public function show(FindCourseByIdRequest $request): JsonResponse
    {
        $course = $this->courseService->getCourseById($request->id);

        return response()->json([
            'data' => $course
        ]);
    }

    public function store(CreateCourseRequest $request): JsonResponse
    {
        $course = $this->courseService->createCourse($request->validated());

        return response()->json([
            'message' => 'Course created successfully.',
            'data' => $course
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateCourseRequest $request): JsonResponse
    {
        $course = $this->courseService->updateCourse($request->id, $request->validated());

        return response()->json([
            'message' => 'Course updated successfully.',
            'data' => $course
        ], Response::HTTP_OK);
    }

    public function destroy(DeleteCourseRequest $request): JsonResponse
    {
        $this->courseService->deleteCourse($request->id);

        return response()->json([
            'message' => 'Course deleted successfully.'
        ], Response::HTTP_OK);
    }
}
