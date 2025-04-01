<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SubjectServiceInterface;
use App\Http\Requests\Subject\FindSubjectByIdRequest;
use App\Http\Requests\Subject\ListSubjectRequest;
use App\Http\Resources\SubjectResource;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
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
        $subjects = $this->subjectService->getAllSubjects($request->filters());

        return response()->json([
            'data' => SubjectResource::collection($subjects),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
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
        $subject = $this->subjectService->getSubjectById($request->id);

        return response()->json([
            'data' => new SubjectResource($subject),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
