<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CreateCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Requests\Course\FindCourseByIdRequest;
use App\Http\Requests\Course\DeleteCourseRequest;
use App\Contracts\Services\CourseManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Course\ListCourseRequest;
use App\Http\Resources\Management\ManagementCourseResource;
use Carbon\Carbon;
class CourseManagementController extends Controller
{
    protected $courseService;

    public function __construct(CourseManagementServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * Get all courses
     *
     * @param ListCourseRequest $request
     * @return JsonResponse
     */
    public function index(ListCourseRequest $request): JsonResponse
    {
        $courses = $this->courseService->getAllCourses($request->filters());

        return response()->json([
            'data' => ManagementCourseResource::collection($courses),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get course by id
     *
     * @param FindCourseByIdRequest $request
     * @return JsonResponse
     */
    public function show(FindCourseByIdRequest $request): JsonResponse
    {
        $course = $this->courseService->getCourseById($request->id);

        return response()->json([
            'data' => new ManagementCourseResource($course),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Create a new course
     *
     * @param CreateCourseRequest $request
     * @return JsonResponse
     */
    public function store(CreateCourseRequest $request): JsonResponse
    {
        $course = $this->courseService->createCourse($request->validated());

        return response()->json([
            'message' => 'Course created successfully.',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_CREATED);
    }

    /**
     * Update a course
     *
     * @param UpdateCourseRequest $request
     * @return JsonResponse
     */
    public function update(UpdateCourseRequest $request): JsonResponse
    {
        $course = $this->courseService->updateCourse($request->id, $request->validated());

        return response()->json([
            'message' => 'Course updated successfully.',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    /**
     * Delete a course
     *
     * @param DeleteCourseRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteCourseRequest $request): JsonResponse
    {
        $this->courseService->deleteCourse($request->id);

        return response()->json([
            'message' => 'Course deleted successfully.',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }
}
