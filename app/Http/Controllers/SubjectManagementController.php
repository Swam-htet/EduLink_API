<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subject\CreateSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Requests\Subject\FindSubjectByIdRequest;
use App\Contracts\Services\SubjectManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SubjectManagementController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectManagementServiceInterface $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function index(): JsonResponse
    {
        $subjects = $this->subjectService->getAllSubjects();

        return response()->json([
            'data' => $subjects
        ]);
    }

    public function show(FindSubjectByIdRequest $request): JsonResponse
    {
        $subject = $this->subjectService->getSubjectById($request->id);

        return response()->json([
            'data' => $subject
        ]);
    }

    public function store(CreateSubjectRequest $request): JsonResponse
    {
        $subject = $this->subjectService->createSubject($request->validated());

        return response()->json([
            'message' => 'Subject created successfully.',
            'data' => $subject
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateSubjectRequest $request): JsonResponse
    {
        $subject = $this->subjectService->updateSubject(
            $request->id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Subject updated successfully.',
            'data' => $subject
        ]);
    }
}
