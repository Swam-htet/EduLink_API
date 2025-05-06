<?php

namespace App\Repositories;

use App\Contracts\Repositories\ExamResultRepositoryInterface;
use App\Models\Tenants\ExamResult;
use Illuminate\Support\Collection;
class ExamResultRepository implements ExamResultRepositoryInterface
{
    protected $model;


    public function __construct(ExamResult $model)
    {
        $this->model = $model;
    }

    public function create(array $data): ExamResult
    {
        return $this->model->create($data);
    }

    public function getExamResultsByExamId(int $examId): Collection
    {
        return $this->model->where('exam_id', $examId)->get();
    }

    public function getExamResultByResultId(int $resultId): ExamResult
    {
        return $this->model->findOrFail($resultId);
    }

    public function getExamResultByStudentIdAndExamId(int $studentId, int $examId) : ?ExamResult
    {
        return $this->model->where(['student_id' => $studentId, 'exam_id' => $examId])->first();
    }

    public function getExamResultByExamIdAndStudentId(int $examId, int $studentId): ExamResult
    {
        return $this->model->where(['exam_id' => $examId, 'student_id' => $studentId])->first();
    }

    public function update(int $resultId, $incrementMarks): bool
    {
        $examResult = $this->getExamResultByResultId($resultId);
        // increase total marks obtained
        // increase count + 1 to correct answers
        // reduce count -1 to wrong answers

        // if condition is auto-generated update to manual-updated

        $examResult->total_marks_obtained += $incrementMarks;
        $examResult->correct_answers += 1;
        $examResult->wrong_answers -= 1;
        if ($examResult->condition === 'auto-generated') {
            $examResult->condition = 'manual-updated';
        }
        return $examResult->save();
    }
}
