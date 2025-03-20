<?php

namespace App\Http\Controllers;

use App\Http\Requests\Class\EnrollStudentRequest;
use App\Contracts\Services\ClassEnrollmentManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Enrollment\ListEnrollmentsRequest;
use App\Http\Requests\Enrollment\UpdateEnrollmentRequest;
use App\Http\Resources\Management\ManagementEnrollmentResource;
use App\Http\Requests\Enrollment\ManualEnrollmentEmailRequest;
class ClassEnrollmentManagementController extends Controller
{
    protected $enrollmentService;

    public function __construct(ClassEnrollmentManagementServiceInterface $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * Get paginated enrollments
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(ListEnrollmentsRequest $request): JsonResponse
    {
        $values = $this->enrollmentService->getPaginatedEnrollments($request->all());
        return response()->json([
            'data' => [
                'enrollments' => ManagementEnrollmentResource::collection($values->items()),
                'meta' => [
                    'total' => $values->total(),
                    'per_page' => $values->perPage(),
                    'current_page' => $values->currentPage(),
                    'last_page' => $values->lastPage(),
                ]
            ]
        ], Response::HTTP_OK);
    }


    /**
     * Enroll student to class
     *
     * @param EnrollStudentRequest $request
     * @return JsonResponse
     */
    public function enrollStudent(EnrollStudentRequest $request): JsonResponse
    {
        $enrollment = $this->enrollmentService->enrollStudent($request->validated());

        return response()->json([
            'message' => 'Student enrolled successfully.',
            'data' => new ManagementEnrollmentResource($enrollment)
        ], Response::HTTP_CREATED);
    }

    /**
     * Update enrollment
     *
     * @param UpdateEnrollmentRequest $request
     * @return JsonResponse
     */
    public function update(UpdateEnrollmentRequest $request): JsonResponse
    {
        $enrollment = $this->enrollmentService->update($request->validated());

        return response()->json([
            'message' => 'Enrollment updated successfully.',
            'data' => new ManagementEnrollmentResource($enrollment)
        ], Response::HTTP_OK);
    }

    /**
     * Send enrollment email
     *
     * @param ManualEnrollmentEmailRequest $request
     * @return JsonResponse
     */
    public function sendManualEnrollmentEmail(ManualEnrollmentEmailRequest $request): JsonResponse
    {
        $this->enrollmentService->sendManualEnrollmentEmail($request->validated());

        return response()->json([
            'message' => 'Enrollment email sent successfully.'
        ], Response::HTTP_OK);
    }
}
