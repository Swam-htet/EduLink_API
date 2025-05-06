<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Exam;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Tenants\Student;
use App\Models\Tenants\ExamResult;
use App\Models\Tenants\StudentExamResponse;
use Illuminate\Support\Collection;

interface ExamServiceInterface
{
    /**
     * Get filtered exams
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getFilteredExams(array $filters): LengthAwarePaginator;

    /**
     * Create new exam
     *
     * @param array $data
     * @return Exam
     */
    public function createExam(array $data): Exam;

    /**
     * Find exam by ID
     *
     * @param int $id
     * @return Exam
     */
    public function findExamById(int $id): Exam;

    /**
     * Update exam
     *
     * @param int $id
     * @param array $data
     * @return Exam
     */
    public function updateExam(int $id, array $data): Exam;

    /**
     * Upload questions to an exam section
     *
     * @param int $examId
     * @param array $data
     * @return Exam
     */
    public function uploadQuestions(int $examId, array $data): Exam;

    /**
     * Publish an exam
     *
     * @param int $id,
     * @return void
     */
    public function publishExam(int $id): void;

    /**
     * Send manual publish exam mail to students
     *
     * @param int $id
     * @return void
     */
    public function sentManualPublishedExamMailToStudents(int $id): void;

    /**
     * Get filtered exams for student
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPublishedExams(array $filters): LengthAwarePaginator;

    /**
     * Get exam by ID
     *
     * @param int $id, Student $student
     * @return Exam
     */
    public function getPublishedExamById(int $id, Student $student): Exam;

    /**
     * Submit exam
     *
     * @param int $id
     * @param array $data
     * @return ExamResult
     */
    public function submitExam(int $id, array $data, Student $student): ExamResult;

    /**
     * Manual grading exam result
     *
     * @param int $answerId
     * @param int $marks
     * @param string $comments
     * @return bool
     */
    public function updateExamResponse(int $answerId, int $resultId, int $marks, string $comments): bool;

    /**
     * Get exam results
     *
     * @param int $id - exam id
     * @return Collection
     */
    public function getExamResultsByExamId(int $examId): Collection;

    /**
     * Get exam result by exam id and student id
     *
     * @param int $examId
     * @param int $studentId
     * @return ExamResult
     */
    public function getExamResultByExamIdAndStudentId(int $examId, int $studentId): ExamResult;

    /**
     * Get exam result by ID
     *
     * @param int $id - exam id
     * @param int $resultId - result id
     * @return ExamResult
     */
    public function getExamResult(int $resultId): ExamResult;

    /**
     * Get answers by exam id and student id
     *
     * @param int $examId
     * @param int $studentId
     * @return Collection
     */
    public function getAnswersByExamIdAndStudentId(int $examId, int $studentId): Collection;

    /**
     * Send exam results to students
     *
     * @param int $examId
     * @return bool
     */
    public function sendExamResultsToStudents(int $examId): bool;
}
