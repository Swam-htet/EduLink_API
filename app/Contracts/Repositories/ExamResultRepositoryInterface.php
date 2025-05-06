<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\ExamResult;
use Illuminate\Support\Collection;
interface ExamResultRepositoryInterface
{
    public function create(array $data): ExamResult;

    public function update(int $resultId, $incrementMarks): bool;

    public function getExamResultByStudentIdAndExamId(int $studentId, int $examId): ?ExamResult;

    public function getExamResultsByExamId(int $examId): Collection;

    public function getExamResultByResultId(int $resultId): ExamResult;

    public function getExamResultByExamIdAndStudentId(int $examId, int $studentId): ExamResult;
}
