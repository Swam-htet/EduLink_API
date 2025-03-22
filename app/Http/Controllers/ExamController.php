<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ExamManagementServiceInterface;
use App\Http\Requests\Exam\ListExamRequest;
use App\Http\Resources\ExamResource;
use App\Http\Resources\Management\ManagementExamResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ExamController extends Controller
{
    protected $examService;

    public function __construct(ExamManagementServiceInterface $examService)
    {
        $this->examService = $examService;
    }

    public function index(ListExamRequest $request): JsonResponse
    {
        $exams = $this->examService->getFilteredExams($request->filters());

        return response()->json([
            'data' => ExamResource::collection($exams),
            'meta' => [
                'total' => $exams->total(),
                'per_page' => $exams->perPage(),
                'current_page' => $exams->currentPage(),
                'last_page' => $exams->lastPage(),
            ]
        ], Response::HTTP_OK);
    }

    public function show(string $id): JsonResponse
    {
        $exam = $this->examService->findExamById((int) $id);

        // Load necessary relationships for detailed view
        $exam->load(['class', 'subject', 'sections.questions']);

        return response()->json([
            'data' => new ManagementExamResource($exam)
        ], Response::HTTP_OK);
    }
}
