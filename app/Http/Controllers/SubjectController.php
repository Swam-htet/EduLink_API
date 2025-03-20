<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SubjectServiceInterface;
use App\Http\Requests\Subject\FindSubjectByIdRequest;
use App\Http\Requests\Subject\ListSubjectRequest;
use App\Http\Resources\SubjectResource;
use Illuminate\Http\JsonResponse;

class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectServiceInterface $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    /**
     * Get all active subjects
     *
     * @return JsonResponse
     */
    public function index(ListSubjectRequest $request): JsonResponse
    {
        $subjects = $this->subjectService->getAllActiveSubjects($request->filters());

        return response()->json([
            'data' => SubjectResource::collection($subjects)
        ]);
    }

    /**
     * Get active subject by ID
     *
     * @param FindSubjectByIdRequest $request
     * @return JsonResponse
     */
    public function show(FindSubjectByIdRequest $request): JsonResponse
    {
        $subject = $this->subjectService->getActiveSubjectById($request->id);

        return response()->json([
            'data' => new SubjectResource($subject)
        ]);
    }
}
