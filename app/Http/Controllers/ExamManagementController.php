<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ExamServiceInterface;
use App\Http\Requests\Exam\ListExamRequest;
use App\Http\Requests\Exam\CreateExamRequest;
use App\Http\Requests\Exam\UpdateExamRequest;
use App\Http\Requests\Exam\UploadExamQuestionRequest;
use App\Http\Resources\Management\ManagementExamResource;
use App\Http\Resources\Management\ManagementExamResultResource;
use App\Http\Resources\Management\ManagementExamResultDetailResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Exam\ManualGradingExamResultRequest;

class ExamManagementController extends Controller
{
    protected $examService;

    public function __construct(ExamServiceInterface $examService)
    {
        $this->examService = $examService;
    }

    public function index(ListExamRequest $request): JsonResponse
    {
        $exams = $this->examService->getFilteredExams($request->filters());

        return response()->json([
            'data' => ManagementExamResource::collection($exams),
            'meta' => [
                'total' => $exams->total(),
                'per_page' => $exams->perPage(),
                'current_page' => $exams->currentPage(),
                'last_page' => $exams->lastPage(),
            ],
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function store(CreateExamRequest $request): JsonResponse
    {
        $this->examService->createExam($request->validated());

        return response()->json([
            'message' => 'Exam created successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_CREATED);
    }

    public function show(string $id): JsonResponse
    {
        $exam = $this->examService->findExamById((int) $id);

        return response()->json([
            'data' => new ManagementExamResource($exam),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function update(UpdateExamRequest $request, string $id): JsonResponse
    {
        $this->examService->updateExam((int) $id, $request->validated());

        return response()->json([
            'message' => 'Exam updated successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function publish(string $id): JsonResponse
    {
        $this->examService->publishExam((int) $id);

        return response()->json([
            'message' => 'Exam published successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function uploadQuestions(UploadExamQuestionRequest $request): JsonResponse
    {
        $this->examService->uploadQuestions(
            (int) $request->exam_id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Questions uploaded successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function sendManualPublishExamMail(string $id): JsonResponse
    {
        $this->examService->sentManualPublishedExamMailToStudents((int) $id);

        return response()->json([
            'message' => 'Exam published successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function getExamResults(string $exam_id): JsonResponse
    {
        $examResults = $this->examService->getExamResultsByExamId((int) $exam_id);

        return response()->json([
            'data' => ManagementExamResultResource::collection($examResults),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function getExamResult(string $exam_id, string $result_id, string $student_id): JsonResponse
    {
        $examResult = $this->examService->getExamResult((int) $result_id);
        $answers = $this->examService->getAnswersByExamIdAndStudentId($exam_id, $student_id);
        return response()->json([
            'data' => new ManagementExamResultDetailResource($examResult, $answers),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }


    public function manualGradingExamResult(ManualGradingExamResultRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $this->examService->updateExamResponse(
            answerId: $validated['answer_id'],
            marks: $validated['marks'],
            comments: $validated['comments'] ?? null
        );

        return response()->json([
            'message' => 'Answer graded successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

    public function sendExamResultsToStudents(string $exam_id): JsonResponse
    {
        $this->examService->sendExamResultsToStudents((int) $exam_id);

        return response()->json([
            'message' => 'Exam results sent to students successfully',
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_OK);
    }

}
