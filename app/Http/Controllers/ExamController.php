<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ExamServiceInterface;
use App\Http\Requests\Exam\ListExamRequest;
use App\Http\Resources\ExamResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Http\Requests\Exam\SubmitExamRequest;
use Illuminate\Http\Request;
use App\Http\Resources\ExamResultResource;

class ExamController extends Controller
{
    protected $examService;

    public function __construct(ExamServiceInterface $examService)
    {
        $this->examService = $examService;
    }

    public function index(ListExamRequest $request): JsonResponse
    {
        $exams = $this->examService->getPublishedExams($request->filters());

        return response()->json([
            'data' => ExamResource::collection($exams),
            'meta' => [
                'total' => $exams->total(),
                'per_page' => $exams->perPage(),
                'current_page' => $exams->currentPage(),
                'last_page' => $exams->lastPage(),
            ],
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function show(string $id, Request $request): JsonResponse
    {
        $student = $request->user();
        $exam = $this->examService->getPublishedExamById((int) $id, $student);


        $exam->load(['class', 'subject', 'sections.questions']);

        return response()->json([
            'data' => new ExamResource($exam),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function submit(string $id, SubmitExamRequest $request): JsonResponse
    {
        $student = $request->user();
        $this->examService->submitExam((int) $id, $request->validated(), $student);

        return response()->json([
            'message' => 'Exam submitted successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function getExamResult(string $id, Request $request): JsonResponse
    {
        $student = $request->user();
        $examResult = $this->examService->getExamResultByExamIdAndStudentId((int) $id, $student->id);
        $answers = $this->examService->getAnswersByExamIdAndStudentId($id, $student->id);

        return response()->json([
            'data' => new ExamResultResource($examResult, $answers),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }
}
