<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClassEnrollmentServiceInterface;
use App\Http\Requests\Enrollment\ConfirmEnrollmentRequest;
use App\Http\Requests\Enrollment\EnrollmentListForStudentRequest;
use App\Http\Resources\ClassEnrollmentResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class ClassEnrollmentController extends Controller
{
    protected $enrollmentService;

    public function __construct(ClassEnrollmentServiceInterface $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * Get student enrollments with filters
     *
     * @param EnrollmentListForStudentRequest $request
     * @return JsonResponse
     */
    public function index(EnrollmentListForStudentRequest $request): JsonResponse
    {
        $enrollments = $this->enrollmentService->getEnrollmentsByStudentId(
            $request->student_id,
            $request->filters()
        );

        return response()->json([
            'data' => ClassEnrollmentResource::collection($enrollments),
            'meta' => [
                'total' => $enrollments->total(),
                'per_page' => $enrollments->perPage(),
                'current_page' => $enrollments->currentPage(),
                'last_page' => $enrollments->lastPage(),
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Confirm class enrollment using invitation token
     *
     * @param ConfirmEnrollmentRequest $request
     * @return JsonResponse
     */
    public function confirmEnrollment(ConfirmEnrollmentRequest $request): JsonResponse
    {
        $enrollment = $this->enrollmentService->confirmEnrollment($request->token);

        return response()->json([
            'message' => 'Enrollment confirmed successfully.',
            'data' => new ClassEnrollmentResource($enrollment)
        ], Response::HTTP_OK);
    }
}
