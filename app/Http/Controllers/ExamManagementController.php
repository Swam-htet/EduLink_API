<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ExamManagementServiceInterface;
use App\Http\Requests\Exam\ListExamRequest;
use App\Http\Requests\Exam\CreateExamRequest;
use App\Http\Requests\Exam\UpdateExamRequest;
use App\Http\Requests\Exam\UploadExamQuestionRequest;
use App\Http\Resources\Management\ManagementExamResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ExamManagementController extends Controller
{
    protected $examManagementService;

    public function __construct(ExamManagementServiceInterface $examManagementService)
    {
        $this->examManagementService = $examManagementService;
    }

    public function index(ListExamRequest $request): JsonResponse
    {
        $exams = $this->examManagementService->getFilteredExams($request->filters());

        return response()->json([
            'data' => ManagementExamResource::collection($exams),
            'meta' => [
                'total' => $exams->total(),
                'per_page' => $exams->perPage(),
                'current_page' => $exams->currentPage(),
                'last_page' => $exams->lastPage(),
            ]
        ], Response::HTTP_OK);
    }

    public function store(CreateExamRequest $request): JsonResponse
    {
        $exam = $this->examManagementService->createExam($request->validated());

        return response()->json([
            'message' => 'Exam created successfully',
            'data' => new ManagementExamResource($exam)
        ], Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $exam = $this->examManagementService->findExamById((int) $id);

        return response()->json([
            'data' => new ManagementExamResource($exam)
        ], Response::HTTP_OK);
    }

    public function update(UpdateExamRequest $request, string $id): JsonResponse
    {
        $exam = $this->examManagementService->updateExam((int) $id, $request->validated());

        return response()->json([
            'message' => 'Exam updated successfully',
            'data' => new ManagementExamResource($exam)
        ], Response::HTTP_OK);
    }

    public function uploadQuestions(UploadExamQuestionRequest $request): JsonResponse
    {
        $exam = $this->examManagementService->uploadQuestions(
            (int) $request->exam_id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Questions uploaded successfully',
            'data' => new ManagementExamResource($exam)
        ], Response::HTTP_OK);
    }
}
