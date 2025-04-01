<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subject\CreateSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Requests\Subject\FindSubjectByIdRequest;
use App\Contracts\Services\SubjectManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Subject\ListSubjectRequest;
use App\Http\Resources\Management\ManagementSubjectResource;
use Carbon\Carbon;

class SubjectManagementController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectManagementServiceInterface $subjectService)
    {
        $this->subjectService = $subjectService;
    }


    /**
     * Get all subjects
     *
     * @param ListSubjectRequest $request
     * @return JsonResponse
     */
    public function index(ListSubjectRequest $request): JsonResponse
    {
        $subjects = $this->subjectService->getAllSubjects($request->filters());

        return response()->json([
            'data' => ManagementSubjectResource::collection($subjects),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get a subject by id
     *
     * @param FindSubjectByIdRequest $request
     * @return JsonResponse
     */
    public function show(FindSubjectByIdRequest $request): JsonResponse
    {
        $subject = $this->subjectService->getSubjectById($request->id);

        return response()->json([
            'data' => new ManagementSubjectResource($subject),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Create a subject
     *
     * @param CreateSubjectRequest $request
     * @return JsonResponse
     */
    public function store(CreateSubjectRequest $request): JsonResponse
    {
        $subject = $this->subjectService->createSubject($request->validated());

        return response()->json([
            'message' => 'Subject created successfully.',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_CREATED);
    }

    /**
     * Update a subject
     *
     * @param UpdateSubjectRequest $request
     * @return JsonResponse
     */
    public function update(UpdateSubjectRequest $request): JsonResponse
    {
        $this->subjectService->updateSubject(
            $request->id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Subject updated successfully.',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Delete a subject
     *
     * @param FindSubjectByIdRequest $request
     * @return JsonResponse
     */
    public function destroy(FindSubjectByIdRequest $request): JsonResponse
    {
        $this->subjectService->deleteSubject($request->id);

        return response()->json([
            'message' => 'Subject deleted successfully.',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
