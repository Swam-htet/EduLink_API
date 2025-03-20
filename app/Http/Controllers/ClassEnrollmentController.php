<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClassEnrollmentServiceInterface;
use App\Http\Requests\Enrollment\ConfirmEnrollmentRequest;
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
            'data' => new ClassEnrollmentResource($enrollment->load(['student', 'class']))
        ], Response::HTTP_OK);
    }
}
